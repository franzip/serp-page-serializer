<?php

namespace Franzip\SerpPageSerializer\SerpPageSerializer\Test;
use Franzip\SerpPageSerializer\Models\SerializableSerpPage;
use Franzip\SerpPageSerializer\SerpPageSerializer;
use Franzip\SerpPageSerializer\Helpers\TestHelper;
use \PHPUnit_Framework_TestCase as PHPUnit_Framework_TestCase;

date_default_timezone_set("Europe/Rome");

class SerializerArgsTest extends PHPUnit_Framework_TestCase
{
    protected $serializablePage;

    protected function setUp()
    {
        $date = new \DateTime();
        $date->setTimeStamp(time());
        $this->serializablePage = new SerializableSerpPage(
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
    }

    /**
     * @expectedException        \Franzip\SerpPageSerializer\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Invalid SerpPageSerializer $cacheDir: please supply a valid non-empty string.
     */
    public function testInvalidArguments()
    {
        $foo = new SerpPageSerializer(2);
    }

    /**
     * @expectedException        \Franzip\SerpPageSerializer\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Invalid SerpPageSerializer $cacheDir: please supply a valid non-empty string.
     */
    public function testInvalidArguments1()
    {
        $foo = new SerpPageSerializer('');
    }

    /**
     * @expectedException        \Franzip\SerpPageSerializer\Exceptions\UnsupportedSerializationFormatException
     * @expectedExceptionMessage Invalid SerpPageSerializer $format: supported serialization formats are JSON, XML and YAML.
     */
    public function testWrongSerializeArgs()
    {
        $foo = new SerpPageSerializer('baz');
        $foo->serialize($this->serializablePage, 'baz');
    }

    /**
     * @expectedException        \Franzip\SerpPageSerializer\Exceptions\UnsupportedSerializationFormatException
     * @expectedExceptionMessage Invalid SerpPageSerializer $format: supported serialization formats are JSON, XML and YAML.
     */
    public function testWrongSerializeArgs1()
    {
        $foo = new SerpPageSerializer('baz');
        $foo->serialize($this->serializablePage, 'baz');
    }

    /**
     * @expectedException        \Franzip\SerpPageSerializer\Exceptions\NonSerializableObjectException
     * @expectedExceptionMessage Invalid SerpPageSerializer $serializablePage: you must supply a SerializableSerpPage object to serialize.
     */
    public function testWrongSerializeArgs2()
    {
        $foo = new SerpPageSerializer('baz');
        $foo->serialize('baz', 'JSON');
    }

    /**
     * @expectedException        \Franzip\SerpPageSerializer\Exceptions\NonSerializableObjectException
     * @expectedExceptionMessage Invalid SerpPageSerializer $serializablePage: you must supply a SerializableSerpPage object to serialize.
     */
    public function testWrongSerializeArgs3()
    {
        $foo = new SerpPageSerializer('baz');
        $foo->serialize(array(), 'XML');
    }

    /**
     * @expectedException        \Franzip\SerpPageSerializer\Exceptions\UnsupportedDeserializationFormatException
     * @expectedExceptionMessage Invalid SerpPageSerializer $format: supported deserialization formats are JSON and XML.
     */
    public function testWrongDeserializeArgs()
    {
        $foo = new SerpPageSerializer('baz');
        $foo->deserialize('', 1);
    }

    /**
     * @expectedException        \Franzip\SerpPageSerializer\Exceptions\UnsupportedDeserializationFormatException
     * @expectedExceptionMessage Invalid SerpPageSerializer $format: supported deserialization formats are JSON and XML.
     */
    public function testWrongDeserializeArgs1()
    {
        $foo = new SerpPageSerializer('baz');
        $foo->deserialize('foo', 'baz');
    }

    /**
     * @expectedException        \Franzip\SerpPageSerializer\Exceptions\RuntimeException
     * @expectedExceptionMessage Invalid SerpPageSerializer $serializedPage: you must supply a SerializedSerpPage object to deserialize.
     */
    public function testWrongDeserializeArgs2()
    {
        $foo = new SerpPageSerializer('baz');
        $foo->deserialize(12, 'xml');
    }

    /**
     * @expectedException        \Franzip\SerpPageSerializer\Exceptions\RuntimeException
     * @expectedExceptionMessage Invalid SerpPageSerializer $serializedPage: you must supply a SerializedSerpPage object to deserialize.
     */
    public function testWrongDeserializeArgs3()
    {
        $foo = new SerpPageSerializer('baz');
        $foo->deserialize('foo', 'xml');
    }

    /**
     * @expectedException        \Franzip\SerpPageSerializer\Exceptions\UnsupportedDeserializationFormatException
     * @expectedExceptionMessage Invalid SerpPageSerializer $format: supported deserialization formats are JSON and XML.
     */
    public function testWrongDeserializeArgs4()
    {
        $foo = new SerpPageSerializer('baz');
        $foo->deserialize('bar', 'yml');
    }

    /**
     * @expectedException        \Franzip\SerpPageSerializer\Exceptions\RuntimeException
     * @expectedExceptionMessage Cannot instantiate a SerializedSerpPage outside SerpPageSerializer.
     */
    public function testSerializedSerpPageInstantiation()
    {
        $foo = new \Franzip\SerpPageSerializer\Models\SerializedSerpPage('foo');
    }
}

class SerializationTest extends PHPUnit_Framework_TestCase
{
    protected $serializablePages;

    protected function setUp()
    {
        mkdir('results');
        $date = new \DateTime();
        // mock time
        $date->setTimeStamp(strtotime('2015-03-19'));
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

    protected function tearDown()
    {
        TestHelper::cleanMess();
    }

    public function testXMLSerialization()
    {
        $foo = new SerpPageSerializer('baz');
        $result = $foo->serialize($this->serializablePages[0], 'xml');
        $this->assertXmlStringEqualsXmlFile('tests/data/test1.xml', $result->getContent());
        $result = $foo->serialize($this->serializablePages[1], 'xml');
        $this->assertXmlStringEqualsXmlFile('tests/data/test2.xml', $result->getContent());
        $result = $foo->serialize($this->serializablePages[2], 'xml');
        $this->assertXmlStringEqualsXmlFile('tests/data/test3.xml', $result->getContent());
        $result = $foo->serialize($this->serializablePages[3], 'xml');
        $this->assertXmlStringEqualsXmlFile('tests/data/test4.xml', $result->getContent());
    }

    public function testJSONSerialization()
    {
        $foo = new SerpPageSerializer('baz');
        $result = $foo->serialize($this->serializablePages[0], 'json');
        $this->assertInstanceOf('\Franzip\SerpPageSerializer\Models\SerializedSerpPage', $result);
        $this->assertJsonStringEqualsJsonFile('tests/data/test1.json', $result->getContent());
        $result = $foo->serialize($this->serializablePages[1], 'JSON');
        $this->assertInstanceOf('\Franzip\SerpPageSerializer\Models\SerializedSerpPage', $result);
        $this->assertJsonStringEqualsJsonFile('tests/data/test2.json', $result->getContent());
        $result = $foo->serialize($this->serializablePages[2], 'json');
        $this->assertInstanceOf('\Franzip\SerpPageSerializer\Models\SerializedSerpPage', $result);
        $this->assertJsonStringEqualsJsonFile('tests/data/test3.json', $result->getContent());
        $result = $foo->serialize($this->serializablePages[3], 'json');
        $this->assertInstanceOf('\Franzip\SerpPageSerializer\Models\SerializedSerpPage', $result);
        $this->assertJsonStringEqualsJsonFile('tests/data/test4.json', $result->getContent());
    }

    public function testYAMLSerialization()
    {
        $foo = new SerpPageSerializer('baz');
        $result = $foo->serialize($this->serializablePages[0], 'yml');
        $this->assertInstanceOf('\Franzip\SerpPageSerializer\Models\SerializedSerpPage', $result);
        file_put_contents('results/test1.yaml', $result->getContent());
        $fixtureData = \Spyc::YAMLLoad('tests/data/test1.yaml');
        $resultData = \Spyc::YAMLLoad('results/test1.yaml');
        $this->assertEquals($fixtureData, $resultData);
        $result = $foo->serialize($this->serializablePages[1], 'yml');
        $this->assertInstanceOf('\Franzip\SerpPageSerializer\Models\SerializedSerpPage', $result);
        file_put_contents('results/test2.yaml', $result->getContent());
        $fixtureData = \Spyc::YAMLLoad('tests/data/test2.yaml');
        $resultData = \Spyc::YAMLLoad('results/test2.yaml');
        $this->assertEquals($fixtureData, $resultData);
        $result = $foo->serialize($this->serializablePages[2], 'yml');
        $this->assertInstanceOf('\Franzip\SerpPageSerializer\Models\SerializedSerpPage', $result);
        file_put_contents('results/test3.yaml', $result->getContent());
        $fixtureData = \Spyc::YAMLLoad('tests/data/test3.yaml');
        $resultData = \Spyc::YAMLLoad('results/test3.yaml');
        $this->assertEquals($fixtureData, $resultData);
        $result = $foo->serialize($this->serializablePages[3], 'yml');
        $this->assertInstanceOf('\Franzip\SerpPageSerializer\Models\SerializedSerpPage', $result);
        file_put_contents('results/test4.yaml', $result->getContent());
        $fixtureData = \Spyc::YAMLLoad('tests/data/test4.yaml');
        $resultData = \Spyc::YAMLLoad('results/test4.yaml');
        $this->assertEquals($fixtureData, $resultData);
    }
}

class DeserializationTest extends PHPUnit_Framework_TestCase
{
    protected $serializablePages;

    protected function setUp()
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

    protected function tearDown()
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
