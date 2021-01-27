# Changelog

All Notable changes to `yaml-front-matter` will be documented in this file

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
