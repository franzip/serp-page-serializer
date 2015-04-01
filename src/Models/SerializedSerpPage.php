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

namespace Franzip\SerpPageSerializer\Models;

/**
 * Simple wrapper around serialized Serp Pages.
 */
class SerializedSerpPage
{
    private $serializedContent;

    /**
     * Wrap a serialized SerpPage into a SerializedSerpPage object.
     * Only allow SerpPageSerializer class to create a SerializedSerpPage.
     * @param string $content
     */
    public function __construct($content)
    {
        $trace = debug_backtrace();
        if ($trace[1]['class'] != 'Franzip\SerpPageSerializer\SerpPageSerializer')
            throw new \Franzip\SerpPageSerializer\Exceptions\RuntimeException('Cannot instantiate a SerializedSerpPage outside SerpPageSerializer.');
        $this->serializedContent = $content;
    }

    /**
     * Get the serialized Serp Page.
     * @return string
     */
    public function getContent()
    {
        return $this->serializedContent;
    }
}
