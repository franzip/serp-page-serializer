<?php

namespace Franzip\SerpPageSerializer\SerializableModels\SerializableSerpPage\Test;
use Franzip\SerpPageSerializer\SerializableModels\SerializableSerpPage;
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
     * @expectedException        InvalidArgumentException
     * @expectedExceptionMessage Please check the supplied arguments and try again
     */
    public function testInvalidEngine()
    {
        $foo = new SerializableSerpPage(0, 'asd', 'foo', 2, $this->date,
                                        array('foo'));
    }

    /**
     * @expectedException        InvalidArgumentException
     * @expectedExceptionMessage Please check the supplied arguments and try again
     */
    public function testInvalidEngine1()
    {
        $foo = new SerializableSerpPage('', 'asd', 'foo', 2, $this->date,
                                        array('foo'));
    }

    /**
     * @expectedException        InvalidArgumentException
     * @expectedExceptionMessage Please check the supplied arguments and try again
     */
    public function testInvalidKeyword()
    {
        $foo = new SerializableSerpPage('foo', 0, 'foo', 2, $this->date,
                                        array('foo'));
    }

    /**
     * @expectedException        InvalidArgumentException
     * @expectedExceptionMessage Please check the supplied arguments and try again
     */
    public function testInvalidKeyword1()
    {
        $foo = new SerializableSerpPage('foo', '', 'foo', 2, $this->date,
                                        array('foo'));
    }

    /**
     * @expectedException        InvalidArgumentException
     * @expectedExceptionMessage Please check the supplied arguments and try again
     */
    public function testInvalidUrl()
    {
        $foo = new SerializableSerpPage('foo', 'baz', 0, 2, $this->date,
                                        array('foo'));
    }

    /**
     * @expectedException        InvalidArgumentException
     * @expectedExceptionMessage Please check the supplied arguments and try again
     */
    public function testInvalidUrl1()
    {
        $foo = new SerializableSerpPage('foo', 'baz', '', 2, $this->date,
                                        array('foo'));
    }

    /**
     * @expectedException        InvalidArgumentException
     * @expectedExceptionMessage Please check the supplied arguments and try again
     */
    public function testInvalidPageNumber()
    {
        $foo = new SerializableSerpPage('foo', 'baz', 'bazfoo', 'foo', $this->date, array('foo'));
    }

    /**
     * @expectedException        InvalidArgumentException
     * @expectedExceptionMessage Please check the supplied arguments and try again
     */
    public function testInvalidPageNumber1()
    {
        $foo = new SerializableSerpPage('foo', 'baz', 'bazfoo', 0, $this->date,
                                        array('foo'));
    }

    /**
     * @expectedException        InvalidArgumentException
     * @expectedExceptionMessage Please check the supplied arguments and try again
     */
    public function testInvalidAge()
    {
        $foo = new SerializableSerpPage('foo', 'baz', 'bazfoo', 2, 'foo',
                                        array('foo'));
    }

    /**
     * @expectedException        InvalidArgumentException
     * @expectedExceptionMessage Please check the supplied arguments and try again
     */
    public function testInvalidAge1()
    {
        $foo = new SerializableSerpPage('foo', 'baz', 'bazfoo', 2, 1, array('foo'));
    }

    /**
     * @expectedException        InvalidArgumentException
     * @expectedExceptionMessage Please check the supplied arguments and try again
     */
    public function testInvalidAge2()
    {
        $foo = new SerializableSerpPage('foo', 'baz', 'bazfoo', 2, array('foo'),
                                        array('foo'));
    }

    /**
     * @expectedException        InvalidArgumentException
     * @expectedExceptionMessage Please check the supplied arguments and try again
     */
    public function testInvalidEntries1()
    {
        $foo = new SerializableSerpPage('foo', 'baz', 'bazfoo', 2, $this->date, 'foo');
    }

    /**
     * @expectedException        InvalidArgumentException
     * @expectedExceptionMessage Please check the supplied arguments and try again
     */
    public function testInvalidEntries()
    {
        $foo = new SerializableSerpPage('foo', 'baz', 'bazfoo', 2, $this->date,
                                        array());
    }

    /**
     * @expectedException        InvalidArgumentException
     * @expectedExceptionMessage Please check the supplied arguments and try again
     */
    public function testInvalidEntries2()
    {
        $foo = new SerializableSerpPage('foo', 'baz', 'bazfoo', 2, $this->date,
                                        array('urls' => 'foo', 'snippets' => 'bar'));
    }

    /**
     * @expectedException        InvalidArgumentException
     * @expectedExceptionMessage Please check the supplied arguments and try again
     */
    public function testInvalidEntries3()
    {
        $foo = new SerializableSerpPage('foo', 'baz', 'bazfoo', 2, $this->date,
                                        array('snippets' => 'bar', 'titles' => 'baz'));
    }

    /**
     * @expectedException        InvalidArgumentException
     * @expectedExceptionMessage Please check the supplied arguments and try again
     */
    public function testInvalidEntries4()
    {
        $foo = new SerializableSerpPage('foo', 'baz', 'bazfoo', 2, $this->date,
                                        array(0 => array('url' => 'bar', 'snippet' => 'bar')));
    }

    public function testValidObject()
    {
        $foo = new SerializableSerpPage('foo', 'baz', 'bazfoo', 2, $this->date,
                                         array(array('url' => 'bar', 'snippet' => 'bar', 'title' => 'foo'),
                                               array('url' => 'barfoo', 'snippet' => 'foobar', 'title' => 'baz')));
    }
}
