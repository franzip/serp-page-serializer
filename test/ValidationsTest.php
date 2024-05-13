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

    public function testInvalidArguments()
    {
        $this->expectException(\Franzip\SerpPageSerializer\Exceptions\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid SerpPageSerializer \$cacheDir: please supply a valid non-empty string.");
        $foo = new SerpPageSerializer(2);
    }

    public function testInvalidArguments1()
    {
        $this->expectException(\Franzip\SerpPageSerializer\Exceptions\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid SerpPageSerializer \$cacheDir: please supply a valid non-empty string.");
        $foo = new SerpPageSerializer('');
    }

    public function testWrongSerializeArgs()
    {
        $this->expectException(\Franzip\SerpPageSerializer\Exceptions\UnsupportedSerializationFormatException::class);
        $this->expectExceptionMessage("Invalid SerpPageSerializer \$format: supported serialization formats are JSON, XML and YAML.");
        $foo = new SerpPageSerializer('baz');
        $foo->serialize($this->serializablePage, 'baz');
    }

    public function testWrongSerializeArgs1()
    {
        $this->expectException(\Franzip\SerpPageSerializer\Exceptions\UnsupportedSerializationFormatException::class);
        $this->expectExceptionMessage("Invalid SerpPageSerializer \$format: supported serialization formats are JSON, XML and YAML.");
        $foo = new SerpPageSerializer('baz');
        $foo->serialize($this->serializablePage, 'baz');
    }

    public function testWrongSerializeArgs2()
    {
        $this->expectException(\Franzip\SerpPageSerializer\Exceptions\NonSerializableObjectException::class);
        $this->expectExceptionMessage("Invalid SerpPageSerializer \$serializablePage: you must supply a SerializableSerpPage object to serialize.");
        $foo = new SerpPageSerializer('baz');
        $foo->serialize('baz', 'JSON');
    }

    public function testWrongSerializeArgs3()
    {
        $this->expectException(\Franzip\SerpPageSerializer\Exceptions\NonSerializableObjectException::class);
        $this->expectExceptionMessage("Invalid SerpPageSerializer \$serializablePage: you must supply a SerializableSerpPage object to serialize.");
        $foo = new SerpPageSerializer('baz');
        $foo->serialize(array(), 'XML');
    }

    public function testWrongDeserializeArgs()
    {
        $this->expectException(\Franzip\SerpPageSerializer\Exceptions\UnsupportedDeserializationFormatException::class);
        $this->expectExceptionMessage("Invalid SerpPageSerializer \$format: supported deserialization formats are JSON and XML.");
        $foo = new SerpPageSerializer('baz');
        $foo->deserialize('', 1);
    }

    public function testWrongDeserializeArgs1()
    {
        $this->expectException(\Franzip\SerpPageSerializer\Exceptions\UnsupportedDeserializationFormatException::class);
        $this->expectExceptionMessage("Invalid SerpPageSerializer \$format: supported deserialization formats are JSON and XML.");
        $foo = new SerpPageSerializer('baz');
        $foo->deserialize('foo', 'baz');
    }

    public function testWrongDeserializeArgs2()
    {
        $this->expectException(\Franzip\SerpPageSerializer\Exceptions\RuntimeException::class);
        $this->expectExceptionMessage("Invalid SerpPageSerializer \$serializedPage: you must supply a SerializedSerpPage object to deserialize.");
        $foo = new SerpPageSerializer('baz');
        $foo->deserialize(12, 'xml');
    }

    public function testWrongDeserializeArgs3()
    {
        $this->expectException(\Franzip\SerpPageSerializer\Exceptions\RuntimeException::class);
        $this->expectExceptionMessage("Invalid SerpPageSerializer \$serializedPage: you must supply a SerializedSerpPage object to deserialize.");
        $foo = new SerpPageSerializer('baz');
        $foo->deserialize('foo', 'xml');
    }

    public function testWrongDeserializeArgs4()
    {
        $this->expectException(\Franzip\SerpPageSerializer\Exceptions\UnsupportedDeserializationFormatException::class);
        $this->expectExceptionMessage("Invalid SerpPageSerializer \$format: supported deserialization formats are JSON and XML.");
        $foo = new SerpPageSerializer('baz');
        $foo->deserialize('bar', 'yml');
    }

    public function testSerializedSerpPageInstantiation()
    {
        $this->expectException(\Franzip\SerpPageSerializer\Exceptions\RuntimeException::class);
        $this->expectExceptionMessage("Cannot instantiate a SerializedSerpPage outside SerpPageSerializer.");
        $foo = new \Franzip\SerpPageSerializer\Models\SerializedSerpPage('foo');
    }
}
