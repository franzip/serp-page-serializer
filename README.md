[![Build Status](https://travis-ci.org/franzip/serp-page-serializer.svg?branch=master)](https://travis-ci.org/franzip/serp-page-serializer)
[![Coverage Status](https://coveralls.io/repos/franzip/serp-page-serializer/badge.svg)](https://coveralls.io/r/franzip/serp-page-serializer)

# SerpPageSerializer
Serialize/deserialize Search Engine Result Pages to JSON, XML and YAML (JMS/Serializer wrapper).

## Installing via Composer (recommended)

Install composer in your project:
```
curl -s http://getcomposer.org/installer | php
```

Create a composer.json file in your project root:
```
{
    "require": {
        "franzip/serp-page-serializer": "0.2.*@dev"
    }
}
```

Install via composer
```
php composer.phar install
```

## Constructor
```php
$serpSerializer = new SerpPageSerializer($cacheDir = "serializer_cache");
```

## Data type constraints

### Serialization
The ```SerpPageSerializer->serialize()``` method accepts only a ```SerializableSerpPage```
object and returns a ```SerializedSerpPage``` object.
The serialized content is available through the ```SerializedSerpPage->getContent()```
method.
Before using the serializer, normalize your data as follows:
```php

use Franzip\SerpPageSerializer\Models\SerializableSerpPage;
// assuming you have extracted the data someway
$serializableSerpPage = new SerializableSerpPage($engine, $keyword, $pageUrl,
                                                 $pageNumber, $age, $entries);
```
Where:

1. `$engine` - string
    - Represents the Search Engine vendor (i.e. Google, Bing, etc).
2. `$keyword` - string
    - Represents the keyword associated to the Search Engine page
3. `$pageUrl` - string
    - Represents the url of the Search Engine for the given keyword/pageNumber
4. `$pageNumber` - integer
    - Represents the page number for the given Search Engine keyword search
5. `$age` - DateTime object
    - Represents when the data were extracted
6. `$entries` - array
    - Represents the core data (see below)

Every Search Engine result page entry has a tripartite structure:

1. A title, usually highlighted in blue.
2. A url.
3. A textual snippet.

![Typical SERP entry structure](./serp-structure.png?raw=true "Typical SERP entry structure")

The $entries array structure must resemble the above mentioned schema, where
the sequential array index stands for the entry position in the page:

```php
array(
      array('url' => 'someurl', 'snippet' => 'somesnippet', 'title' => 'sometitle'),
      array('url' => 'someurl', 'snippet' => 'somesnippet', 'title' => 'sometitle'),
      array('url' => 'someurl', 'snippet' => 'somesnippet', 'title' => 'sometitle'),
      ...
     );
```
### Deserialization

The ```SerpPageSerializer->deserialize()``` only accepts a ```SerializedSerpPage```
as argument, yielding back a ```SerpPageJSON``` or a ```SerpPageXML``` object.

## Usage (serialize data)

```php

use Franzip\SerpPageSerializer\SerpPageSerializer;
use Franzip\SerpPageSerializer\Models\SerializableSerpPage;

$engine = 'google';
$keyword = 'foobar';
$pageUrl = 'https://www.google.com/search?q=foobar';
$pageNumber = 1;
$age = new \DateTime();
$age->setTimeStamp(time());
$entries = array(array('url' => 'www.foobar2000.org',
                       'title' => 'foobar2000',
                       'snippet' => 'blabla'),
                 array(...),
                 ...);

$serpSerializer = new SerpPageSerializer();
$pageToSerialize = new SerializableSerpPage($engine, $keyword, $pageUrl,
                                            $pageNumber, $age, $entries);

$serializedXMLData = $serpSerializer->serialize($pageToSerialize->getContent(), 'xml');
var_dump($serializedXMLData);

/*
 * <?xml version="1.0" encoding="UTF-8"?>
 *  <serp_page engine="google" page_number="1" page_url="https://www.google.com/search?q=foobar" keyword="foobar" age="2015-03-19">
 *    <entry position="1">
 *      <url>www.foobar2000.org</url>
 *      <title>foobar2000</title>
 *      <snippet>blabla</snippet>
 *    </entry>
 *    <entry position="2">
 *      ...
 *    </entry>
 *  </serp_page>
 */

$serializedJSONData = $serpSerializer->serialize($pageToSerialize->getContent(), 'json');
var_dump($serializedJSONData);

/*
 * {
 *   "engine": "google",
 *   "page_number": 1,
 *   "page_url": "https:\/\/www.google.com\/search?q=foobar",
 *   "keyword":"foobar",
 *   "age":"2015-03-19",
 *   "entries":[
 *     {
 *       "position": 1,
 *       "url": "www.foobar2000.org",
 *       "title": "foobar2000",
 *       "snippet": "blabla"
 *     },
 *     {
 *       "position": 2,
 *       ...
 *     },
 *     ...
 *   ]
 * }
 */

$serializedYAMLData = $serpSerializer->serialize($pageToSerialize->getContent(), 'yml');
var_dump($serializedYAMLData);

/*
 * engine: google
 * page_number: 1
 * page_url: 'http://www.google.com/search?q=foobar'
 * keyword: foobar
 * age: '2015-03-19'
 * entries:
 *     -
 *         position: 1
 *         url: 'www.foobar2000.org'
 *         title: foobar2000
 *         snippet: blabla
 *     -
 *         position: 2
 *         ...
 *     -
 *
 */ ...
```

## Usage (deserialize data)

YAML deserialization **is not supported.**

```php

use Franzip\SerpPageSerializer\SerpPageSerializer;

$serpSerializer = new SerpPageSerializer();

$serpPageXML = $serpSerializer->deserialize($serializedXMLPage, 'xml');

var_dump($serializedXMLPage);

// object(Franzip\SerpPageSerializer\Models\SerializedSerpPage) (1) {
// ...

var_dump($serpPageXML);

// object(Franzip\SerpPageSerializer\Models\SerpPageXML) (6) {
// ...

$serpPageJSON = $serpSerializer->deserialize($serializedJSONPage, 'json');

var_dump($serializedJSONPage);

// object(Franzip\SerpPageSerializer\Models\SerializedSerpPage) (1) {
// ...

var_dump($serpPageJSON);

// object(Franzip\SerpPageSerializer\Models\SerpPageJSON) (6) {
// ...

```

## TODOs

- [x] Add a default $cacheDir to constructor.
- [x] A decent exceptions system.
- [x] Allow typechecking on deserialization by wrapping serialized strings in
 a dedicated class.
- [x] Fix serialization tests.
- [x] Fix deserialization tests.
- [x] Rewrite docs.
- [ ] YAML deserialization support.
- [ ] CSV serialization/deserialization support.
- [ ] Fix messy tests.

## License
[MIT](http://opensource.org/licenses/MIT/ "MIT") Public License.
