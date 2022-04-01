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
     * Attempts to follow the practices defined in https://jekyllrb.com/docs/front-matter/.
     *
     * Fixes https://github.com/spatie/yaml-front-matter/discussions/30.
     *
     * @param string $content
     * @return Document
     */
    public static function markdownCompatibleParse(string $content): Document
    {
        // Turn the string into an array of lines, making the code easier to understand
        $lines = explode("\n", $content);

        // Find the line numbers of the front matter start and end blocks
        $frontMatterControlBlockIndex = [];
        foreach ($lines as $lineNumber => $lineContents) {
            // If the line starts with three dashes, it's a front matter control block
            if (substr($lineContents, 0, 3) === '---') {
                // The line contains the front matter control block
                if (sizeof($frontMatterControlBlockIndex) === 0) {
                    // This is the first control block
                    $frontMatterControlBlockIndex['start'] = $lineNumber;
                } elseif (sizeof($frontMatterControlBlockIndex) === 1) {
                    // This is the second control block
                    $frontMatterControlBlockIndex['end'] = $lineNumber;
                    // We can now break the loop because we found the end of the actual front matter
                    break;
                }
            }
        }

        // If there are no front matter blocks, we just return the content as is
        if (sizeof($frontMatterControlBlockIndex) < 2) {
            return new Document([], $content);
        }

        // Construct the new line arrays
        $matter = [];
        $body = [];

        // Loop through the original line array
        foreach ($lines as $lineNumber => $lineContents) {
            // Compare the line number to the one of the closing front matter block
            // to determine if we're in the front matter or the body
            if ($lineNumber <= $frontMatterControlBlockIndex['end']) {
                $matter[] = $lineContents;
            } else {
                $body[] = $lineContents;
            }
        }

        // Remove the dashes
        unset($matter[$frontMatterControlBlockIndex['start']]);
        unset($matter[$frontMatterControlBlockIndex['end']]);

        // If the first line of the body is empty, remove it
        if (trim($body[0]) === '') {
            unset($body[0]);
        }

        // Convert the lines back into strings
        $matter = implode("\n", $matter);
        $body = implode("\n", $body);
        
        // Parse the front matter
        $matter = Yaml::parse($matter);

        // Return the document
        return new Document($matter, $body);
    }

    public static function parseFile(string $path): Document
    {
        return static::parse(
            file_get_contents($path)
        );
    }
}
