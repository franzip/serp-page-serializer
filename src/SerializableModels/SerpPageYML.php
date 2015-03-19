<?php

namespace Franzip\SerpPageSerializer\SerializableModels;
use JMS\Serializer\Annotation\Type;

/**
 * Map a whole Search Engine result page to an easily YAML serializable object
 * Each entry is represented by a SerpPageEntryYML object
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
    /** @Type("array<Franzip\SerpPageSerializer\SerializableModels\SerpPageEntryYML>") */
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
