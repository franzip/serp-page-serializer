<?php

namespace Franzip\SerpPageSerializer\SerializableModels;
use JMS\Serializer\Annotation\XmlAttribute;
use JMS\Serializer\Annotation\XmlList;
use JMS\Serializer\Annotation\XmlRoot;
use JMS\Serializer\Annotation\Type;

/**
 * Map a whole Search Engine result page to an easily XML serializable object.
 * Each entry is represented by a SerpPageEntryXML object.
 * @package SerpPageSerializer
 */
/** @XmlRoot("serp_page") */
class SerpPageXML
{
    /** @XmlAttribute @Type("string") */
    private $engine;
    /** @XmlAttribute @Type("integer") */
    private $pageNumber;
    /** @XmlAttribute @Type("string") */
    private $pageUrl;
    /** @XmlAttribute @Type("string") */
    private $keyword;
    /** @XmlAttribute @Type("DateTime<'Y-m-d'>") */
    private $age;
    /** @XmlList(inline = true, entry = "entry") @Type("array<Franzip\SerpPageSerializer\SerializableModels\SerpPageEntryXML>") */
    private $entries;

    /**
     * Instantiate a SerpPageXML object.
     * @param string   $engine
     * @param int      $pageNumber
     * @param string   $pageUrl
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
