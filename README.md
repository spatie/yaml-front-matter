# yaml-front-matter

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/yaml-front-matter.svg?style=flat-square)](https://packagist.org/packages/spatie/yaml-front-matter)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/spatie/yaml-front-matter/master.svg?style=flat-square)](https://travis-ci.org/spatie/yaml-front-matter)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/e8934dc2-3075-40a4-a2e9-10bc24cc7101.svg?style=flat-square)](https://insight.sensiolabs.com/projects/e8934dc2-3075-40a4-a2e9-10bc24cc7101)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/yaml-front-matter.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/yaml-front-matter)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/yaml-front-matter.svg?style=flat-square)](https://packagist.org/packages/spatie/yaml-front-matter)

A to the point front matter parser. Front matter is metadata written in yaml, located at the top of a file wrapped in `---`'s.

```md
---
title: Example
---

Lorem ipsum.
```

```php
$object = $parser->parse(file_get_contents(__DIR__'/example.md'));

$object->matter('title'); // => 'Example';
$object->body(); // => 'Lorem ipsum.'
```

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

## Install

You can install the `yaml-front-matter` via composer:

``` bash
$ composer require spatie/yaml-front-matter
```

## Usage

Consider the `example.md` file from above. First you'll need to parse the contents:

```php
$parser = new \Spatie\YamlFrontMatter\YamlFrontMatterParser();

$object = $parser->parse(file_get_contents(__DIR__'/example.md'));
```

The parser will return a `YamlFrontMatterObject`, which can be queried for front matter or it's body.

```php
$object->matter(); // => ['title' => 'Example'];
$object->matter('title'); // => 'Example';
$object->body(); // => 'Lorem ipsum.'
```

**Protip**: The `matter` function also accepts dot notation for nested fields, e.g. `matter('meta.keywords')`.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ vendor/bin/phpspec run
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Credits

- [Sebastian De Deyne](https://github.com/:author_username)
- [All Contributors](../../contributors)

## About Spatie
Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
