<?php

namespace Franzip\SerpPageSerializer\SerializableModels;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlRoot;
use JMS\Serializer\Annotation\XmlAttribute;
use JMS\Serializer\Annotation\XmlElement;

/**
 * Map a single Search Engine result page entry to an easily XML serializable object.
 * Each entry has a url, a title and a snippet.
 * @package SerpPageSerializer
 */

/** @XmlRoot("entry") */
class SerpPageEntryXML
{
    /** @XmlAttribute @Type("integer") */
    private $position;
    /** @XmlElement(cdata=false) @Type("string") */
    private $url;
    /** @XmlElement(cdata=false) @Type("string") */
    private $title;
    /** @XmlElement(cdata=false) @Type("string") */
    private $snippet;

    /**
     * Instatiate a SerpPageEntryXML
     * @param int    $position
     * @param string $url
     * @param string $title
     * @param string $snippet
     */
    public function __construct($position, $url, $title, $snippet)
    {
        $this->position = $position;
        $this->url      = $url;
        $this->title    = $title;
        $this->snippet  = $snippet;
    }
}
