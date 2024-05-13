<?php

namespace Franzip\SerpPageSerializer\SerpPageSerializer\Test;
use Franzip\SerpPageSerializer\Models\SerializableSerpPage;
use Franzip\SerpPageSerializer\SerpPageSerializer;
use Franzip\SerpPageSerializer\Helpers\TestHelper;
use \PHPUnit\Framework\TestCase;

final class ValidationsTest extends TestCase
{
    protected $serializablePage;

    protected function setUp(): void
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
