# Changelog

All Notable changes to `yaml-front-matter` will be documented in this file

## 2.1.0 - 2024-12-02

### What's Changed

* PHP 8.4 support by @brendt in https://github.com/spatie/yaml-front-matter/pull/42
* Drop PHP 7 support

### New Contributors

* @brendt made their first contribution in https://github.com/spatie/yaml-front-matter/pull/42

**Full Changelog**: https://github.com/spatie/yaml-front-matter/compare/2.0.9...2.1.0

## 2.0.9 - 2024-06-13

### What's Changed

* Check if the array key is set before trying to trim it by @caendesilva in https://github.com/spatie/yaml-front-matter/pull/41

**Full Changelog**: https://github.com/spatie/yaml-front-matter/compare/2.0.8...2.0.9

## 2.0.8 - 2023-12-04

### What's Changed

* Add PHP 8.2 Support by @patinthehat in https://github.com/spatie/yaml-front-matter/pull/39
* Support Symfony 7 by @RobinDev in https://github.com/spatie/yaml-front-matter/pull/40

### New Contributors

* @RobinDev made their first contribution in https://github.com/spatie/yaml-front-matter/pull/40

**Full Changelog**: https://github.com/spatie/yaml-front-matter/compare/2.0.7...2.0.8

## 2.0.7 - 2022-04-06

## What's Changed

- Fix #30, bug where the package cannot properly parse a file that contains Markdown code blocks with front matter in them by @caendesilva in https://github.com/spatie/yaml-front-matter/pull/38

## New Contributors

- @caendesilva made their first contribution in https://github.com/spatie/yaml-front-matter/pull/38

**Full Changelog**: https://github.com/spatie/yaml-front-matter/compare/2.0.6...2.0.7

## 2.0.6 - 2021-12-22

- Support Symfony 6

**Full Changelog**: https://github.com/spatie/yaml-front-matter/compare/2.0.5...2.0.6

## 2.0.6 - 2021-12-22

- Support Symfony 6

## 2.0.5 - 2019-12-02

- Allow Symfony 5 (#20)

## 2.0.4 - 2019-09-12

- Remove `illuminate/support` dependency

## 2.0.3 - 2019-09-04

- Allow `illuminate/support:^6.0`

## 2.0.2 - 2018-02-23

- Fix for documents with no newline after front matter

## 2.0.1 - 2017-09-04

- Fix for documents with empty front matter

## 2.0.0 - 2017-08-21

- Renamed `Parser` class to `YamlFrontMatter`
- `parse` and `parseFile` are now static methods
- `Document` now has a `__get` implementation for retrieving front matter

## 1.1.0 - 2017-07-12

- Added `parseFile`

## 1.0.1 - 2016-01-27

- Parser regex improvements

## 1.0.0 - 2016-01-14

- First release
