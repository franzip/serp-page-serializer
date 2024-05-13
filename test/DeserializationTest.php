<?php

namespace Franzip\SerpPageSerializer\SerpPageSerializer\Test;
use Franzip\SerpPageSerializer\Models\SerializableSerpPage;
use Franzip\SerpPageSerializer\SerpPageSerializer;
use Franzip\SerpPageSerializer\Helpers\TestHelper;
use \PHPUnit\Framework\TestCase;

date_default_timezone_set("Europe/Rome");


final class DeserializationTest extends TestCase
{
    protected $serializablePages;

    protected function setUp(): void
    {
        mkdir('results');
        $date = new \DateTime();
        $date->setTimeStamp(time());
        $date->format('Y-m-d');
        $serializablePage1 = new SerializableSerpPage(
                                                'google', 'baz',
                                                'http://www.google.com',
                                                1, $date,
                                                array(
                                                    array(
                                                        'url' => 'http://www.google.com',
                                                        'snippet' => 'baz',
                                                        'title' => 'foo'),
                                                    array(
                                                        'url' => 'http://www.google.com',
                                                        'snippet' => 'baz',
                                                        'title' => 'foo')
                                                ));
        $serializablePage2 = new SerializableSerpPage(
                                                'ask', 'foobaz',
                                                'http://www.ask.com',
                                                1, $date,
                                                array(
                                                    array(
                                                        'url' => 'http://www.ask.com',
                                                        'snippet' => 'foobaz',
                                                        'title' => 'baz'),
                                                    array(
                                                        'url' => 'http://www.ask.com',
                                                        'snippet' => 'bazfoo',
                                                        'title' => 'foo')
                                                ));
        $serializablePage3 = new SerializableSerpPage(
                                                'bing', 'baz',
                                                'http://www.bing.com',
                                                5, $date,
                                                array(
                                                    array(
                                                        'url' => 'http://www.bing.com',
                                                        'snippet' => 'bazfoo',
                                                        'title' => 'foobaz'),
                                                    array(
                                                        'url' => 'http://www.bing.com',
                                                        'snippet' => 'foobazbaz',
                                                        'title' => 'bazfoo')
                                                ));
        $serializablePage4 = new SerializableSerpPage(
                                                'yahoo', 'baz',
                                                'http://www.yahoo.com',
                                                3, $date,
                                                array(
                                                    array(
                                                        'url' => 'http://www.yahoo.com',
                                                        'snippet' => 'boom',
                                                        'title' => 'baz'),
                                                    array(
                                                        'url' => 'http://www.yahoo.com',
                                                        'snippet' => 'bazfo',
                                                        'title' => 'foobad')
                                                ));
        $serializablePages = array($serializablePage1, $serializablePage2,
                                   $serializablePage3, $serializablePage4);
        $this->serializablePages = $serializablePages;
    }

    protected function tearDown(): void
    {
        TestHelper::cleanMess();
    }

    public function testXMLDeserialization()
    {
        $foo = new SerpPageSerializer('baz');
        $createEntries = TestHelper::getMethod('createEntries',
                                               'Franzip\SerpPageSerializer\SerpPageSerializer');
        $prepareForSerialization = TestHelper::getMethod('prepareForSerialization',
                                                         'Franzip\SerpPageSerializer\SerpPageSerializer');
        $serialized = $foo->serialize($this->serializablePages[0], 'xml');
        $deserialized = $foo->deserialize($serialized, 'xml');
        $entries = $createEntries->invokeArgs($foo, array($this->serializablePages[0], 'xml'));
        $serpPageXML = $prepareForSerialization->invokeArgs($foo, array($this->serializablePages[0], 'xml', $entries));
        $this->assertEquals($deserialized, $serpPageXML);
        $data = $foo->serialize($this->serializablePages[1], 'XML');
        $deserialized = $foo->deserialize($data, 'xml');
        $entries = $createEntries->invokeArgs($foo, array($this->serializablePages[1], 'xml'));
        $serpPageXML = $prepareForSerialization->invokeArgs($foo, array($this->serializablePages[1], 'xml', $entries));
        $this->assertEquals($deserialized, $serpPageXML);
        $data = $foo->serialize($this->serializablePages[2], 'xml');
        $deserialized = $foo->deserialize($data, 'xml');
        $entries = $createEntries->invokeArgs($foo, array($this->serializablePages[2], 'xml'));
        $serpPageXML = $prepareForSerialization->invokeArgs($foo, array($this->serializablePages[2], 'xml', $entries));
        $this->assertEquals($deserialized, $serpPageXML);
        $data = $foo->serialize($this->serializablePages[3], 'xml');
        $deserialized = $foo->deserialize($data, 'xml');
        $entries = $createEntries->invokeArgs($foo, array($this->serializablePages[3], 'xml'));
        $serpPageXML = $prepareForSerialization->invokeArgs($foo, array($this->serializablePages[3], 'xml', $entries));
        $this->assertEquals($deserialized, $serpPageXML);
    }

    public function testJSONDeserialization()
    {
        $foo = new SerpPageSerializer('baz');
        $createEntries = TestHelper::getMethod('createEntries',
                                         'Franzip\SerpPageSerializer\SerpPageSerializer');
        $prepareForSerialization = TestHelper::getMethod('prepareForSerialization',
                                         'Franzip\SerpPageSerializer\SerpPageSerializer');
        $data = $foo->serialize($this->serializablePages[0], 'json');
        $deserialized = $foo->deserialize($data, 'json');
        $entries = $createEntries->invokeArgs($foo, array($this->serializablePages[0], 'json'));
        $serpPageJSON = $prepareForSerialization->invokeArgs($foo, array($this->serializablePages[0], 'json', $entries));
        $this->assertEquals($deserialized, $serpPageJSON);
        $data = $foo->serialize($this->serializablePages[1], 'json');
        $deserialized = $foo->deserialize($data, 'json');
        $entries = $createEntries->invokeArgs($foo, array($this->serializablePages[1], 'json'));
        $serpPageJSON = $prepareForSerialization->invokeArgs($foo, array($this->serializablePages[1], 'json', $entries));
        $this->assertEquals($deserialized, $serpPageJSON);
        $data = $foo->serialize($this->serializablePages[2], 'json');
        $deserialized = $foo->deserialize($data, 'json');
        $entries = $createEntries->invokeArgs($foo, array($this->serializablePages[2], 'json'));
        $serpPageJSON = $prepareForSerialization->invokeArgs($foo, array($this->serializablePages[2], 'json', $entries));
        $this->assertEquals($deserialized, $serpPageJSON);
        $data = $foo->serialize($this->serializablePages[3], 'json');
        $deserialized = $foo->deserialize($data, 'json');
        $entries = $createEntries->invokeArgs($foo, array($this->serializablePages[3], 'json'));
        $serpPageJSON = $prepareForSerialization->invokeArgs($foo, array($this->serializablePages[3], 'json', $entries));
        $this->assertEquals($deserialized, $serpPageJSON);
    }
}
