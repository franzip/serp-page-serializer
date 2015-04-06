<?php

namespace Franzip\SerpPageSerializer\Models\SerializableSerpPage\Test;
use Franzip\SerpPageSerializer\Models\SerializableSerpPage;
use \PHPUnit_Framework_TestCase as PHPUnit_Framework_TestCase;

date_default_timezone_set("Europe/Rome");

class SerializableSerpPageTest extends PHPUnit_Framework_TestCase
{
    protected $date;

    protected function setUp()
    {
        $date = new \DateTime();
        $date->setTimeStamp(time());
        $this->date = $date;
    }

    /**
     * @expectedException        \Franzip\SerpPageSerializer\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Invalid SerializableSerpPage $engine: please supply a valid non-empty string.
     */
    public function testInvalidEngine()
    {
        $foo = new SerializableSerpPage(0, 'asd', 'www.google.com', 2, $this->date,
                                        array('foo'));
    }

    /**
     * @expectedException        \Franzip\SerpPageSerializer\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Invalid SerializableSerpPage $engine: please supply a valid non-empty string.
     */
    public function testInvalidEngine1()
    {
        $foo = new SerializableSerpPage('', 'asd', 'www.google.com', 2, $this->date,
                                        array('foo'));
    }

    /**
     * @expectedException        \Franzip\SerpPageSerializer\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Invalid SerializableSerpPage $keyword: please supply a valid non-empty string.
     */
    public function testInvalidKeyword()
    {
        $foo = new SerializableSerpPage('foo', 0, 'www.google.com', 2, $this->date,
                                        array('foo'));
    }

    /**
     * @expectedException        \Franzip\SerpPageSerializer\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Invalid SerializableSerpPage $keyword: please supply a valid non-empty string.
     */
    public function testInvalidKeyword1()
    {
        $foo = new SerializableSerpPage('foo', '', 'www.google.com', 2, $this->date,
                                        array('foo'));
    }

    /**
     * @expectedException        \Franzip\SerpPageSerializer\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Invalid SerializableSerpPage $pageUrl: supplied URL appears to be invalid.
     */
    public function testInvalidUrl()
    {
        $foo = new SerializableSerpPage('foo', 'baz', 0, 2, $this->date,
                                        array('foo'));
    }

    /**
     * @expectedException        \Franzip\SerpPageSerializer\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Invalid SerializableSerpPage $pageUrl: supplied URL appears to be invalid.
     */
    public function testInvalidUrl1()
    {
        $foo = new SerializableSerpPage('foo', 'baz', '', 2, $this->date,
                                        array('foo'));
    }

    /**
     * @expectedException        \Franzip\SerpPageSerializer\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Invalid SerializableSerpPage $pageNumber: please supply a positive integer.
     */
    public function testInvalidPageNumber()
    {
        $foo = new SerializableSerpPage('foo', 'baz', 'www.google.com', 'foo', $this->date, array('foo'));
    }

    /**
     * @expectedException        \Franzip\SerpPageSerializer\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Invalid SerializableSerpPage $pageNumber: please supply a positive integer.
     */
    public function testInvalidPageNumber1()
    {
        $foo = new SerializableSerpPage('foo', 'baz', 'www.google.com', 0, $this->date,
                                        array('foo'));
    }

    /**
     * @expectedException        \Franzip\SerpPageSerializer\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Invalid SerializableSerpPage $age: $age must be a DateTime object.
     */
    public function testInvalidAge()
    {
        $foo = new SerializableSerpPage('foo', 'baz', 'www.google.com', 2, 'foo',
                                        array('foo'));
    }

    /**
     * @expectedException        \Franzip\SerpPageSerializer\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Invalid SerializableSerpPage $age: $age must be a DateTime object.
     */
    public function testInvalidAge1()
    {
        $foo = new SerializableSerpPage('foo', 'baz', 'www.google.com', 2, 1, array('foo'));
    }

    /**
     * @expectedException        \Franzip\SerpPageSerializer\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Invalid SerializableSerpPage $age: $age must be a DateTime object.
     */
    public function testInvalidAge2()
    {
        $foo = new SerializableSerpPage('foo', 'baz', 'www.google.com', 2, array('foo'),
                                        array('foo'));
    }

    /**
     * @expectedException        \Franzip\SerpPageSerializer\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Invalid SerializableSerpPage $entries: $entries must be an array with the following structure. array(0 => array('url' => 'someurl', 'snippet' => 'somesnippet', 'title' => 'sometitle'), 1 => array('url' => 'someurl', 'snippet' => 'somesnippet', 'title' => 'sometitle'), ...
     */
    public function testInvalidEntries1()
    {
        $foo = new SerializableSerpPage('foo', 'baz', 'www.google.com', 2, $this->date, 'foo');
    }

    /**
     * @expectedException        \Franzip\SerpPageSerializer\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Invalid SerializableSerpPage $entries: $entries must be an array with the following structure. array(0 => array('url' => 'someurl', 'snippet' => 'somesnippet', 'title' => 'sometitle'), 1 => array('url' => 'someurl', 'snippet' => 'somesnippet', 'title' => 'sometitle'), ...
     */
    public function testInvalidEntries()
    {
        $foo = new SerializableSerpPage('foo', 'baz', 'www.google.com', 2, $this->date,
                                        array());
    }

    /**
     * @expectedException        \Franzip\SerpPageSerializer\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Invalid SerializableSerpPage $entries: $entries must be an array with the following structure. array(0 => array('url' => 'someurl', 'snippet' => 'somesnippet', 'title' => 'sometitle'), 1 => array('url' => 'someurl', 'snippet' => 'somesnippet', 'title' => 'sometitle'), ...
     */
    public function testInvalidEntries2()
    {
        $foo = new SerializableSerpPage('foo', 'baz', 'www.google.com', 2, $this->date,
                                        array('urls' => 'foo', 'snippets' => 'bar'));
    }

    /**
     * @expectedException        \Franzip\SerpPageSerializer\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Invalid SerializableSerpPage $entries: $entries must be an array with the following structure. array(0 => array('url' => 'someurl', 'snippet' => 'somesnippet', 'title' => 'sometitle'), 1 => array('url' => 'someurl', 'snippet' => 'somesnippet', 'title' => 'sometitle'), ...
     */
    public function testInvalidEntries3()
    {
        $foo = new SerializableSerpPage('foo', 'baz', 'www.google.com', 2, $this->date,
                                        array('snippets' => 'bar', 'titles' => 'baz'));
    }

    /**
     * @expectedException        \Franzip\SerpPageSerializer\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Invalid SerializableSerpPage $entries: $entries must be an array with the following structure. array(0 => array('url' => 'someurl', 'snippet' => 'somesnippet', 'title' => 'sometitle'), 1 => array('url' => 'someurl', 'snippet' => 'somesnippet', 'title' => 'sometitle'), ...
     */
    public function testInvalidEntries4()
    {
        $foo = new SerializableSerpPage('foo', 'baz', 'www.google.com', 2, $this->date,
                                        array(0 => array('url' => 'bar', 'snippet' => 'bar')));
    }

    public function testValidObject()
    {
        $foo = new SerializableSerpPage('foo', 'baz', 'www.google.com', 2, $this->date,
                                         array(array('url' => 'bar', 'snippet' => 'bar', 'title' => 'foo'),
                                               array('url' => 'barfoo', 'snippet' => 'foobar', 'title' => 'baz')));
        $this->assertEquals($foo->getEngine(), 'foo');
        $this->assertEquals($foo->getKeyword(), 'baz');
        $this->assertEquals($foo->getPageUrl(), 'www.google.com');
        $this->assertEquals($foo->getPageNumber(), 2);
        $this->assertEquals($foo->getAge(), $this->date);
        $this->assertEquals($foo->getEntries(),
                            array(array('url' => 'bar', 'snippet' => 'bar', 'title' => 'foo'),
                                  array('url' => 'barfoo', 'snippet' => 'foobar', 'title' => 'baz')));
    }
}
