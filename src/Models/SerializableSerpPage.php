<?php

/**
 * SerpPageSerializer -- Serialize/deserialize Search Engine Result Pages to
 * JSON, XML and YAML (JMS/Serializer wrapper).
 * @version 1.0.0
 * @author Francesco Pezzella <franzpezzella@gmail.com>
 * @link https://github.com/franzip/serp-page-serializer
 * @copyright Copyright 2015 Francesco Pezzella
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @package SerpPageSerializer
 */

namespace Franzip\SerpPageSerializer\Models;
use Franzip\SerpPageSerializer\Helpers\SerializableSerpPageHelper;

/**
 * Provide a convenient data abstraction for SerpPageSerializer class.
 * The only serious constraint here is represented by the $entries array.
 * It must be in the following form:
 *
 * array(0 => array('url' => 'someurl', 'snippet' => 'somesnippet', 'title => 'sometitle'),
 *       1 => array('url' => 'someurl', 'snippet' => 'somesnippet', 'title => 'sometitle'),
 *       ...)
 *
 * With the array index representing the entry position starting from 0 in the Serp page to serialize.
 *
 * @package SerpPageSerializer
 */
class SerializableSerpPage
{
    // search engine vendor
    private $engine;
    // keyword associated to the search engine page
    private $keyword;
    // url of the page to serialize
    private $pageUrl;
    // search engine result page number
    private $pageNumber;
    // DateTime object
    private $age;
    // array with the page data (urls, snippets and titles)
    private $entries;

    /**
     * Construct a SerializableSerpPage object.
     * @param string   $engine
     * @param string   $keyword
     * @param string   $pageUrl
     * @param int      $pageNumber
     * @param DateTime $age
     * @param array    $entries
     */
    public function __construct($engine, $keyword, $pageUrl, $pageNumber,
                                $age, $entries)
    {
        // perform validations
        SerializableSerpPageHelper::validateData($engine, $keyword, $pageUrl,
                                                 $pageNumber, $age, $entries);

        $this->engine     = $engine;
        $this->keyword    = $keyword;
        $this->pageUrl    = $pageUrl;
        $this->pageNumber = $pageNumber;
        $this->age        = $age;
        $this->entries    = $entries;
    }

    /**
     * Get the engine vendor.
     * @return string
     */
    public function getEngine()
    {
        return $this->engine;
    }

    /**
     * Get the keyword.
     * @return string
     */
    public function getKeyword()
    {
        return $this->keyword;
    }

    /**
     * Get the page Url.
     * @return string
     */
    public function getPageUrl()
    {
        return $this->pageUrl;
    }

    /**
     * Get the page number.
     * @return int
     */
    public function getPageNumber()
    {
        return $this->pageNumber;
    }

    /**
     * Get the age.
     * @return DateTime
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Get the entries array.
     * @return array
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * Dump object data.
     * @return return
     */
    public function dumpObject()
    {
        $date = $this->age->format('Y-m-d');
        $string = "Engine: $this->engine \n";
        $string .= "Keyword: $this->keyword \n";
        $string .= "PageUrl: $this->pageUrl \n";
        $string .= "PageNumber: $this->pageNumber \n";
        $string .= "Date: $date \n";
        $string .= "Entries: \n";
        for ($i = 0; $i < count($this->entries); $i++) {
            $url     = $this->entries[$i]['url'];
            $title   = $this->entries[$i]['title'];
            $snippet = $this->entries[$i]['snippet'];
            $pos = $i + 1;
            $string .= "    $pos: \n";
            $string .= "        Url: $url\n";
            $string .= "        Title: $title\n";
            $string .= "        Snippet: $snippet\n";
        }
        return $string;
    }
}
