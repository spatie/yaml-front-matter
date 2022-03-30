<?php

namespace Spatie\YamlFrontMatter;

use Symfony\Component\Yaml\Yaml;

class YamlFrontMatter
{
    public static function parse(string $content): Document
    {
        $pattern = '/^[\s\r\n]?---[\s\r\n]?$/sm';

        $parts = preg_split($pattern, PHP_EOL.ltrim($content));

        if (count($parts) < 3) {
            return new Document([], $content);
        }

        $matter = Yaml::parse(trim($parts[1]));

        $body = implode(PHP_EOL.'---'.PHP_EOL, array_slice($parts, 2));

        return new Document($matter, $body);
    }

    /**
     * A parser that can handle Markdown that contains Markdown.
     *
     * Fixes https://github.com/spatie/yaml-front-matter/discussions/30.
     * Original code by https://github.com/eklausme
     *
     * @param string $content
     * @return Document
     */
    public static function markdownCompatibleParse(string $content): Document
    {
        $n3dash = 0;    // count number of triple dashes
        $pos1 = 0;
        $pos2 = 0;
        $len = strlen($content);

        for ($pos = 0; ; $pos += 3) {
            $pos = strpos($content, '---', $pos);
            if ($pos === false) return new Document([], $content);   // no pair of triple dashes at all
            // Are we at end or is next character white space?
            if ($pos + 3 == $len || ctype_space(substr($content, $pos + 3, 1))) {
                if ($n3dash == 0 && ($pos == 0 || $pos > 0 && substr($content, $pos - 1, 1) == "\n")) {
                    $n3dash = 1;    // found first triple dash
                    $pos1 = $pos + 3;
                } else if ($n3dash == 1 && substr($content, $pos - 1, 1) == "\n") {
                    // found 2nd properly enclosed triple dash
                    $n3dash = 2;
                    $pos2 = $pos + 3;
                    break;
                }
            }
        }
        $matter = substr($content, $pos1, $pos2 - 3 - $pos1);
        $body = substr($content, $pos2);
        $matter = Yaml::parse($matter);

        return new Document($matter, $body);
    }

    public static function parseFile(string $path): Document
    {
        return static::parse(
            file_get_contents($path)
        );
    }
}
