<?php

namespace Franzip\SerpPageSerializer\Models\SerializableSerpPage\Test;
use Franzip\SerpPageSerializer\Models\SerializableSerpPage;
use \PHPUnit\Framework\TestCase;

date_default_timezone_set("Europe/Rome");

final class SerializableSerpPageTest extends TestCase
{
    protected $date;

    protected function setUp(): void
    {
        $date = new \DateTime();
        $date->setTimeStamp(time());
        $this->date = $date;
    }

    public function testInvalidEngine()
    {
        $this->expectException(\Franzip\SerpPageSerializer\Exceptions\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid SerializableSerpPage \$engine: please supply a valid non-empty string.");
        $foo = new SerializableSerpPage(0, 'asd', 'www.google.com', 2, $this->date,
                                        array('foo'));
    }

    public function testInvalidEngine1()
    {
        $this->expectException(\Franzip\SerpPageSerializer\Exceptions\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid SerializableSerpPage \$engine: please supply a valid non-empty string.");
        $foo = new SerializableSerpPage('', 'asd', 'www.google.com', 2, $this->date,
                                        array('foo'));
    }

    public function testInvalidKeyword()
    {
        $this->expectException(\Franzip\SerpPageSerializer\Exceptions\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid SerializableSerpPage \$keyword: please supply a valid non-empty string.");
        $foo = new SerializableSerpPage('foo', 0, 'www.google.com', 2, $this->date,
                                        array('foo'));
    }

    public function testInvalidKeyword1()
    {
        $this->expectException(\Franzip\SerpPageSerializer\Exceptions\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid SerializableSerpPage \$keyword: please supply a valid non-empty string.");
        $foo = new SerializableSerpPage('foo', '', 'www.google.com', 2, $this->date,
                                        array('foo'));
    }

    public function testInvalidUrl()
    {
        $this->expectException(\Franzip\SerpPageSerializer\Exceptions\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid SerializableSerpPage \$pageUrl: supplied URL appears to be invalid.");
        $foo = new SerializableSerpPage('foo', 'baz', 0, 2, $this->date,
                                        array('foo'));
    }

    public function testInvalidUrl1()
    {
        $this->expectException(\Franzip\SerpPageSerializer\Exceptions\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid SerializableSerpPage \$pageUrl: supplied URL appears to be invalid.");
        $foo = new SerializableSerpPage('foo', 'baz', '', 2, $this->date,
                                        array('foo'));
    }

    public function testInvalidPageNumber()
    {
        $this->expectException(\Franzip\SerpPageSerializer\Exceptions\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid SerializableSerpPage \$pageNumber: please supply a positive integer.");
        $foo = new SerializableSerpPage('foo', 'baz', 'www.google.com', 'foo', $this->date, array('foo'));
    }

    public function testInvalidPageNumber1()
    {
        $this->expectException(\Franzip\SerpPageSerializer\Exceptions\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid SerializableSerpPage \$pageNumber: please supply a positive integer.");
        $foo = new SerializableSerpPage('foo', 'baz', 'www.google.com', 0, $this->date,
                                        array('foo'));
    }

    public function testInvalidAge()
    {
        $this->expectException(\Franzip\SerpPageSerializer\Exceptions\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid SerializableSerpPage \$age: \$age must be a DateTime object.");
        $foo = new SerializableSerpPage('foo', 'baz', 'www.google.com', 2, 'foo',
                                        array('foo'));
    }

    public function testInvalidAge1()
    {
        $this->expectException(\Franzip\SerpPageSerializer\Exceptions\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid SerializableSerpPage \$age: \$age must be a DateTime object.");
        $foo = new SerializableSerpPage('foo', 'baz', 'www.google.com', 2, 1, array('foo'));
    }

    public function testInvalidAge2()
    {
        $this->expectException(\Franzip\SerpPageSerializer\Exceptions\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid SerializableSerpPage \$age: \$age must be a DateTime object.");
        $foo = new SerializableSerpPage('foo', 'baz', 'www.google.com', 2, array('foo'),
                                        array('foo'));
    }

    public function testInvalidEntries1()
    {
        $this->expectException(\Franzip\SerpPageSerializer\Exceptions\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid SerializableSerpPage \$entries: \$entries must be an array with the following structure. array(0 => array('url' => 'someurl', 'snippet' => 'somesnippet', 'title' => 'sometitle'), 1 => array('url' => 'someurl', 'snippet' => 'somesnippet', 'title' => 'sometitle'), ...");
        $foo = new SerializableSerpPage('foo', 'baz', 'www.google.com', 2, $this->date, 'foo');
    }

    public function testInvalidEntries()
    {
        $this->expectException(\Franzip\SerpPageSerializer\Exceptions\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid SerializableSerpPage \$entries: \$entries must be an array with the following structure. array(0 => array('url' => 'someurl', 'snippet' => 'somesnippet', 'title' => 'sometitle'), 1 => array('url' => 'someurl', 'snippet' => 'somesnippet', 'title' => 'sometitle'), ...");
        $foo = new SerializableSerpPage('foo', 'baz', 'www.google.com', 2, $this->date,
                                        array());
    }

    public function testInvalidEntries2()
    {
        $this->expectException(\Franzip\SerpPageSerializer\Exceptions\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid SerializableSerpPage \$entries: \$entries must be an array with the following structure. array(0 => array('url' => 'someurl', 'snippet' => 'somesnippet', 'title' => 'sometitle'), 1 => array('url' => 'someurl', 'snippet' => 'somesnippet', 'title' => 'sometitle'), ...");
        $foo = new SerializableSerpPage('foo', 'baz', 'www.google.com', 2, $this->date,
                                        array('urls' => 'foo', 'snippets' => 'bar'));
    }

    public function testInvalidEntries3()
    {
        $this->expectException(\Franzip\SerpPageSerializer\Exceptions\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid SerializableSerpPage \$entries: \$entries must be an array with the following structure. array(0 => array('url' => 'someurl', 'snippet' => 'somesnippet', 'title' => 'sometitle'), 1 => array('url' => 'someurl', 'snippet' => 'somesnippet', 'title' => 'sometitle'), ...");
        $foo = new SerializableSerpPage('foo', 'baz', 'www.google.com', 2, $this->date,
                                        array('snippets' => 'bar', 'titles' => 'baz'));
    }

    public function testInvalidEntries4()
    {
        $this->expectException(\Franzip\SerpPageSerializer\Exceptions\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid SerializableSerpPage \$entries: \$entries must be an array with the following structure. array(0 => array('url' => 'someurl', 'snippet' => 'somesnippet', 'title' => 'sometitle'), 1 => array('url' => 'someurl', 'snippet' => 'somesnippet', 'title' => 'sometitle'), ...");
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
