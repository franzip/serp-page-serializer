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
use JMS\Serializer\Annotation\Type;

/**
 * Map a whole Search Engine result page to an easily YAML serializable object.
 * Each entry is represented by a SerpPageEntryYML object.
 * @package SerpPageSerializer
 */
class SerpPageYML
{
    /** @Type("string") */
    private $engine;
    /** @Type("integer") */
    private $pageNumber;
    /** @Type("string") */
    private $pageUrl;
    /** @Type("string") */
    private $keyword;
    /** @Type("DateTime<'Y-m-d'>") */
    private $age;
    /** @Type("array<Franzip\SerpPageSerializer\Models\SerpPageEntryYML>") */
    private $entries;

    /**
     * Instantiate a SerpPageYAML object.
     * @param string   $engine
     * @param int      $pageNumber
     * @param string   $keyword
     * @param DateTime $age
     * @param array    $entries
     */
    public function __construct($engine, $pageNumber, $pageUrl, $keyword, $age, $entries)
    {
        $this->engine     = $engine;
        $this->pageNumber = $pageNumber;
        $this->pageUrl    = $pageUrl;
        $this->keyword    = $keyword;
        $this->age        = $age;
        $this->entries    = $entries;
    }
}
