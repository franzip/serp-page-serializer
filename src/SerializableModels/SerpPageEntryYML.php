<?php

namespace Franzip\SerpPageSerializer\SerializableModels;
use JMS\Serializer\Annotation\Type;


/**
 * Map a single Search Engine result page entry to an easily YAML serializable object
 * Each entry has a url, a title and a snippet
 */
class SerpPageEntryYML
{
    /** @Type("integer") */
    private $position;
    /** @Type("string") */
    private $url;
    /** @Type("string") */
    private $title;
    /** @Type("string") */
    private $snippet;

    /**
     * Instatiate a SerpPageEntryYAML
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
