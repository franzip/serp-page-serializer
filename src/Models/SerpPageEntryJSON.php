<?php

/**
 * SerpPageSerializer -- Serialize/deserialize Search Engine Result Pages to
 * JSON and XML (JMS/Serializer wrapper).
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
 * Map a single Search Engine result page entry to an easily JSON serializable object.
 * Each entry has a url, a title and a snippet.
 * @package SerpPageSerializer
 */
class SerpPageEntryJSON
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
     * Instatiate a SerpPageEntryJSON.
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
