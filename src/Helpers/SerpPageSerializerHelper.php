<?php

namespace Franzip\SerpPageSerializer\Helpers;

/**
 * Namespace SerpPageSerializer various helpers methods.
 * @package SerpPageSerializer
 */
class SerpPageSerializerHelper
{
    /**
     * Validate the supplied cache directory path
     * @param  string $cacheDir
     * @return bool
     */
    public static function validateDir($cacheDir)
    {
        return is_string($cacheDir) && !empty($cacheDir);
    }

    /**
     * Check whether a given serialization/deserialization format is supported
     * @param  string $format
     * @param  array  $validFormats
     * @return bool
     */
    public static function validFormat($format, $validFormats)
    {
        return is_string($format)
               && in_array(strtolower($format), $validFormats);
    }

    /**
     * Check if a supplied object is serializable.
     * @param  SerializableSerpPage $object
     * @return bool
     */
    public static function serializablePage($object)
    {
        return is_a($object, "Franzip\SerpPageSerializer\Models\SerializableSerpPage");
    }

    /**
     * Check if a supplied object is deserializable.
     * @param  SerializedSerpPage $serializedPage
     * @return bool
     */
    public static function deserializablePage($serializedPage)
    {
        return is_a($serializedPage, "Franzip\SerpPageSerializer\Models\SerializedSerpPage");
    }

    /**
     * JMS/Serializer does not beautify JSON output, so do it.
     * @param  string $json
     * @return string
     */
    public static function prettyJSON($json) {

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

    private function __construct() {}
}
