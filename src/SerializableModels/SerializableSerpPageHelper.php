<?php

namespace Franzip\SerpPageSerializer\SerializableModels;

/**
 * Namespace SerializableSerpPage helpers methods.
 *
 * @package SerpPageSerializer
 */
class SerializableSerpPageHelper
{
    // url regex validation pattern
    private static $urlPattern = "/(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}(\.[a-z]{2,6}|:[0-9]{3,4})\b([-a-zA-Z0-9@:%_\+.~#?&\/\/=]*)/i";
    // allow $entries array structure validation
    private static $modelArray = array("url" => 0, "snippet" => 0, "title" => 0);

    /**
     * Validate SerializableSerpPage constructor data.
     * @param  string   $engine
     * @param  string   $keyword
     * @param  string   $pageUrl
     * @param  int      $pageNumber
     * @param  DateTime $age
     * @param  array    $entries
     * @return bool
     */
    public static function validateData($engine, $keyword, $pageUrl, $pageNumber,
                                        $age, $entries)
    {
        if (!self::validateEngine($engine))
            throw new \Franzip\SerpPageSerializer\Exceptions\InvalidArgumentException('Invalid SerializableSerpPage $engine: please supply a valid non-empty string.');

        if (!self::validateKeyword($keyword))
            throw new \Franzip\SerpPageSerializer\Exceptions\InvalidArgumentException('Invalid SerializableSerpPage $keyword: please supply a valid non-empty string.');

        if (!self::validatePageUrl($pageUrl))
            throw new \Franzip\SerpPageSerializer\Exceptions\InvalidArgumentException('Invalid SerializableSerpPage $pageUrl: supplied URL appears to be invalid.');

        if (!self::validatePageNumber($pageNumber))
            throw new \Franzip\SerpPageSerializer\Exceptions\InvalidArgumentException('Invalid SerializableSerpPage $pageNumber: please supply a positive integer.');

        if (!self::validateAge($age))
            throw new \Franzip\SerpPageSerializer\Exceptions\InvalidArgumentException('Invalid SerializableSerpPage $age: $age must be a DateTime object.');

        if (!self::validateEntries($entries))
            throw new \Franzip\SerpPageSerializer\Exceptions\InvalidArgumentException('Invalid SerializableSerpPage $entries: $entries must be an array with the following structure. array(0 => array(\'url\' => \'someurl\', \'snippet\' => \'somesnippet\', \'title\' => \'sometitle\'), 1 => array(\'url\' => \'someurl\', \'snippet\' => \'somesnippet\', \'title\' => \'sometitle\'), ...');
    }

    /**
     * Validate engine.
     * @param  string $engine
     * @return bool
     */
    private static function validateEngine($engine)
    {
        return is_string($engine) && !empty($engine);
    }

    /**
     * Validate keyword.
     * @param  string $keyword
     * @return bool
     */
    private static function validateKeyword($keyword)
    {
        return is_string($keyword) && !empty($keyword);
    }

    /**
     * Validate page URL.
     * @param  string $pageUrl
     * @return bool
     */
    private static function validatePageUrl($pageUrl)
    {
        return preg_match(self::$urlPattern, $pageUrl);
    }

    /**
     * Validate page number.
     * @param  int $pageNumber
     * @return bool
     */
    private static function validatePageNumber($pageNumber)
    {
        return is_int($pageNumber) && $pageNumber > 0;
    }

    /**
     * Validate age.
     * @param  DateTime $age
     * @return bool
     */
    private static function validateAge($age)
    {
        return is_a($age, 'DateTime');
    }

    /**
     * Check entries array structure.
     * The entries array must have the following structure:
     * array(0 => array('url' => 'someurl', 'snippet' => 'somesnippet', 'title' => 'sometitle'),
     *       1 => array('url' => 'someurl', 'snippet' => 'somesnippet', 'title' => 'sometitle'),
     *       ...)
     * @param  array  $entries
     * @return bool
     */
    private static function validateEntries($entries)
    {
        $checkArr = self::$modelArray;
        return is_array($entries) && !empty($entries)
               && array_keys($entries) === range(0, count($entries) - 1)
               && !in_array(false, array_map(function($arr) use ($checkArr) {
                    $diff = array_diff_key($checkArr, $arr);
                    return empty($diff);
               }, $entries));
    }

    private function __construct() {}
}
