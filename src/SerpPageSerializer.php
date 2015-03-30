<?php

/**
 * SerpPageSerializer -- Serialize/deserialize Search Engine Result Pages to
 * JSON, XML and YAML (JMS/Serializer wrapper).
 * @version 0.1.0
 * @author Francesco Pezzella <franzpezzella@gmail.com>
 * @link https://github.com/franzip/serp-page-serializer
 * @copyright Copyright 2015 Francesco Pezzella
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @package SerpPageSerializer
 */

namespace Franzip\SerpPageSerializer;
use JMS\Serializer\SerializerBuilder;

\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');

/**
 * Serialize/Deserialize Search Engine result page to XML, JSON and YAML.
 * The SerpPageSerializer->serialize() accepts only a SerializableSerpPage as input.
 * YAML deserialization is not currently supported.
 * @package SerpPageSerializer
 */
class SerpPageSerializer
{
    // namespace constants
    const SERIALIZABLE_OBJECT_PREFIX = "Franzip\SerpPageSerializer\SerializableModels\SerpPage";
    const SERIALIZABLE_OBJECT_ENTRY  = "Entry";
    // supported serialization/deserialization formats
    static private $supportedFormatSerialization   = array('xml', 'json', 'yml');
    // JMS/Serializar does not support YAML deserialization
    static private $supportedFormatDeserialization = array('xml', 'json');
    // underlying serializer instance (a JMS/Serializer object)
    private $serializer;

    /**
     * Instantiate a SerpPageSerializer
     * @param string $cacheDir
     */
    public function __construct($cacheDir)
    {
        if (!self::validDir($cacheDir))
            throw new \InvalidArgumentException("Please supply a valid folder name");
        $this->serializer = SerializerBuilder::create()->setCacheDir($cacheDir)->build();
    }

    /**
     * Serialize a SerializableSerpPage object in the target format
     * @param  SerializableSerpPage $serializablePage
     * @param  string               $format
     * @return string
     */
    public function serialize($serializablePage, $format)
    {
        if (!self::validSerializationFormat($format))
            throw new \InvalidArgumentException('Invalid format.');
        if (!self::serializablePage($serializablePage))
            throw new \InvalidArgumentException('You must supply a SerializableSerpPage object.');
        $format           = strtolower($format);
        $entries          = $this->createEntries($serializablePage, $format);
        $serializablePage = $this->prepareForSerialization($serializablePage, $format, $entries);
        $serializedPage   = $this->getSerializer()->serialize($serializablePage, $format);
        // beautify output if JSON
        return ($format == 'json') ? $this->prettyJSON($serializedPage) : $serializedPage;
    }

    /**
     * Deserialize a serialized page.
     * YAML deserialization is not currently supported
     * @param  string $serializedPage
     * @param  string $format
     * @return SerpPageXML|SerpPageJSON
     */
    public function deserialize($serializedPage, $format)
    {
        if (!self::validDeserializationFormat($format))
            throw new \InvalidArgumentException('Invalid format.');
        if (!self::deserializablePage($serializedPage))
            throw new \InvalidArgumentException('Something went wrong. Check your arguments.');
        $targetClass = self::SERIALIZABLE_OBJECT_PREFIX . strtoupper($format);
        return $this->getSerializer()->deserialize($serializedPage, $targetClass, $format);
    }

    /**
     * Return the underlying serializer instance
     * @return JMS\Serializer\Serializer
     */
    public function getSerializer()
    {
        return $this->serializer;
    }

    /**
     * Map SerializableSerpPage to an easy serializable SerpPage.
     * The serialization format is resolved at runtime.
     * @param  SerializableSerpPage $serializablePage
     * @param  string               $format
     * @param  array                $entries
     * @return SerpPageJSON|SerpPageXML|SerpPageYML
     */
    private function prepareForSerialization($serializablePage, $format, $entries)
    {
        $engine     = $serializablePage->getEngine();
        $keyword    = $serializablePage->getKeyword();
        $pageUrl    = $serializablePage->getPageUrl();
        $pageNumber = $serializablePage->getPageNumber();
        $age        = $serializablePage->getAge();
        return self::getFormatClassName($format, array($engine, $pageNumber, $pageUrl,
                                        $keyword, $age, $entries));
    }

    /**
     * Map SerializableSerpPage entries to SerpPageEntries.
     * The serialization format is resolved at runtime.
     * @param  SerializableSerpPage $serializablePage
     * @param  string               $format
     * @return SerpPageEntryJSON|SerpPageEntryXML|SerpPageEntryYAML
     */
    private function createEntries($serializablePage, $format)
    {
        $result = array();
        $entries = $serializablePage->getEntries();
        for ($i = 0; $i < count($entries); $i++) {
            $args = array(($i + 1), $entries[$i]['url'], $entries[$i]['title'], $entries[$i]['snippet']);
            array_push($result, self::getFormatClassName($format, $args, true));
        }
        return $result;
    }

    /**
     * Get a SerializableModel at runtime for a given serialization format
     * The $entry variable flags if the returned object should be just a serializable
     * entry or the full serializable page.
     * @param  string  $format
     * @param  array   $args
     * @param  boolean $entry
     * @return mixed
     */
    private static function getFormatClassName($format, $args, $entry = false)
    {
        $formatName = strtoupper($format);
        $className  = self::SERIALIZABLE_OBJECT_PREFIX;
        if ($entry)
            $className  .= self::SERIALIZABLE_OBJECT_ENTRY;
        $className .= $formatName;
        return call_user_func_array(array(new \ReflectionClass($className), 'newInstance'),
                                    $args);
    }

    /**
     * The object to serialize must be an instance of SerializableSerpPage
     * @param  SerializableSerpPage $object
     * @return bool
     */
    private static function serializablePage($object)
    {
        return is_a($object, "Franzip\SerpPageSerializer\SerializableModels\SerializableSerpPage");
    }

    /**
     * Basic validation for deserialization.
     * TODO: maybe a SerializedSerpPage wrapper to allow typecheck?
     * @param  string $page
     * @return bool
     */
    private static function deserializablePage($page)
    {
        return is_string($page) && !empty($page);
    }

    /**
     * JMS/Serializer does not beautify JSON output, so do it.
     * @param  string $json
     * @return string
     */
    private function prettyJSON($json) {

        $result      = '';
        $pos         = 0;
        $strLen      = strlen($json);
        $indentStr   = '  ';
        $newLine     = "\n";
        $prevChar    = '';
        $outOfQuotes = true;

        for ($i=0; $i<=$strLen; $i++) {

            // Grab the next character in the string.
            $char = substr($json, $i, 1);

            // Are we inside a quoted string?
            if ($char == '"' && $prevChar != '\\') {
                $outOfQuotes = !$outOfQuotes;

            // If this character is the end of an element,
            // output a new line and indent the next line.
            } else if(($char == '}' || $char == ']') && $outOfQuotes) {
                $result .= $newLine;
                $pos --;
                for ($j=0; $j<$pos; $j++) {
                    $result .= $indentStr;
                }
            }

            // Add the character to the result string.
            $result .= $char;

            // If the last character was the beginning of an element,
            // output a new line and indent the next line.
            if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
                $result .= $newLine;
                if ($char == '{' || $char == '[') {
                    $pos ++;
                }

                for ($j = 0; $j < $pos; $j++) {
                    $result .= $indentStr;
                }
            }

            $prevChar = $char;
        }

        return $result;
    }

    /**
     * Check if the serialization format is supported
     * @param  string $format
     * @return bool
     */
    private static function validSerializationFormat($format)
    {
        return is_string($format)
               && in_array(strtolower($format), self::$supportedFormatSerialization);
    }

    /**
     * Check if the deserialization format is supported
     * @param  string $format
     * @return bool
     */
    private static function validDeserializationFormat($format)
    {
        return is_string($format)
               && in_array(strtolower($format), self::$supportedFormatDeserialization);
    }

    /**
     * Basic validation for the constructor.
     * @param  string $cacheDir
     * @return bool
     */
    private static function validDir($cacheDir)
    {
        return is_string($cacheDir) && !empty($cacheDir);
    }
}
