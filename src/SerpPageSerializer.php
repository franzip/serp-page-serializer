<?php

/**
 * SerpPageSerializer -- Serialize/deserialize Search Engine Result Pages to
 * JSON, XML and YAML (JMS/Serializer wrapper).
 * @version 0.2.0
 * @author Francesco Pezzella <franzpezzella@gmail.com>
 * @link https://github.com/franzip/serp-page-serializer
 * @copyright Copyright 2015 Francesco Pezzella
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @package SerpPageSerializer
 */

namespace Franzip\SerpPageSerializer;
use Franzip\SerpPageSerializer\Helpers\SerpPageSerializerHelper;
use Franzip\SerpPageSerializer\Models\SerializedSerpPage;
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
    const SERIALIZABLE_OBJECT_PREFIX = "Franzip\SerpPageSerializer\Models\SerpPage";
    const SERIALIZABLE_OBJECT_ENTRY  = "Entry";
    // default cache dir
    const DEFAULT_SERIALIZER_CACHE_DIR = 'serializer_cache';
    // supported serialization/deserialization formats
    private static $supportedFormatSerialization   = array('xml', 'json', 'yml');
    // JMS/Serializar does not support YAML deserialization
    private static $supportedFormatDeserialization = array('xml', 'json');
    // underlying serializer instance (a JMS/Serializer object)
    private $serializer;

    /**
     * Instantiate a SerpPageSerializer
     * @param string $cacheDir
     */
    public function __construct($cacheDir = self::DEFAULT_SERIALIZER_CACHE_DIR)
    {
        if (!SerpPageSerializerHelper::validateDir($cacheDir))
            throw new \Franzip\SerpPageSerializer\Exceptions\InvalidArgumentException('Invalid SerpPageSerializer $cacheDir: please supply a valid non-empty string.');
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
        // check if supported serialization format
        if (!SerpPageSerializerHelper::validFormat($format, self::$supportedFormatSerialization))
            throw new \Franzip\SerpPageSerializer\Exceptions\UnsupportedSerializationFormatException('Invalid SerpPageSerializer $format: supported serialization formats are JSON, XML and YAML.');
        // typecheck the object to serialize
        if (!SerpPageSerializerHelper::serializablePage($serializablePage))
            throw new \Franzip\SerpPageSerializer\Exceptions\NonSerializableObjectException('Invalid SerpPageSerializer $serializablePage: you must supply a SerializableSerpPage object to serialize.');

        $format           = strtolower($format);
        $entries          = $this->createEntries($serializablePage, $format);
        $serializablePage = $this->prepareForSerialization($serializablePage, $format, $entries);
        $serializedPage   = $this->getSerializer()->serialize($serializablePage, $format);
        // beautify output if JSON
        $content          = ($format == 'json') ? SerpPageSerializerHelper::prettyJSON($serializedPage) : $serializedPage;
        return new SerializedSerpPage($content);
    }

    /**
     * Deserialize a serialized page.
     * YAML deserialization is not currently supported.
     * @param  SerializedSerpPage   $serializedPage
     * @param  string               $format
     * @return SerializableSerpPage
     */
    public function deserialize($serializedPage, $format)
    {
        // check if supported deserialization format
        if (!SerpPageSerializerHelper::validFormat($format, self::$supportedFormatDeserialization))
            throw new \Franzip\SerpPageSerializer\Exceptions\UnsupportedDeserializationFormatException('Invalid SerpPageSerializer $format: supported deserialization formats are JSON and XML.');
        // TODO: typecheck object
        if (!SerpPageSerializerHelper::deserializablePage($serializedPage))
            throw new \Franzip\SerpPageSerializer\Exceptions\RuntimeException('Invalid SerpPageSerializer $serializedPage: you must supply a SerializedSerpPage object to deserialize.');

        $format = strtolower($format);
        $targetClass = self::SERIALIZABLE_OBJECT_PREFIX . strtoupper($format);
        return $this->getSerializer()->deserialize($serializedPage->getContent(), $targetClass, $format);
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
            $className .= self::SERIALIZABLE_OBJECT_ENTRY;
        $className .= $formatName;
        return call_user_func_array(array(new \ReflectionClass($className), 'newInstance'),
                                    $args);
    }
}
