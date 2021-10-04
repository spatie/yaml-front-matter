# yaml-front-matter

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/yaml-front-matter.svg?style=flat-square)](https://packagist.org/packages/spatie/yaml-front-matter)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/spatie/yaml-front-matter/master.svg?style=flat-square)](https://travis-ci.org/spatie/yaml-front-matter)
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
use Spatie\YamlFrontMatter\YamlFrontMatter;

$object = YamlFrontMatter::parse(file_get_contents(__DIR__.'/example.md'));

$object->matter('title'); // => 'Example';
$object->body(); // => 'Lorem ipsum.'

// Or retrieve front matter with a property call...

$object->title; // => 'Example';
```

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/yaml-front-matter.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/yaml-front-matter)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Install

You can install the `yaml-front-matter` via composer:

``` bash
$ composer require spatie/yaml-front-matter
```

## Usage

Consider the `example.md` file from above. First you'll need to parse the contents:

```php
use Spatie\YamlFrontMatter\YamlFrontMatter;
$object = YamlFrontMatter::parse(file_get_contents('example.md'));
```

The parser will return a `YamlFrontMatterObject`, which can be queried for front matter or it's body.

```php
$object->matter(); // => ['title' => 'Example']
$object->matter('title'); // => 'Example'
$object->body(); // => 'Lorem ipsum.'
$object->title; // => 'Example'
```

**Protip**: The `matter` function also accepts dot notation for nested fields, e.g. `matter('meta.keywords')`.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ vendor/bin/phpunit
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Postcardware

You're free to use this package, but if it makes it to your production environment we highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Spatie, Kruikstraat 22, 2018 Antwerp, Belgium.

We publish all received postcards [on our company website](https://spatie.be/en/opensource/postcards).

## Credits

- [Sebastian De Deyne](https://github.com/:author_username)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
