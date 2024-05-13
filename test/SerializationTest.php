<?php

namespace Franzip\SerpPageSerializer\SerpPageSerializer\Test;
use Franzip\SerpPageSerializer\Models\SerializableSerpPage;
use Franzip\SerpPageSerializer\SerpPageSerializer;
use Franzip\SerpPageSerializer\Helpers\TestHelper;
use \PHPUnit\Framework\TestCase;

date_default_timezone_set("Europe/Rome");


final class SerializationTest extends TestCase
{
    protected $serializablePages;

    protected function setUp(): void
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

    protected function tearDown(): void
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
