<?php

namespace Spatie\YamlFrontMatter;

use Exception;
use Symfony\Component\Yaml\Yaml;

class Parser
{
    protected $yamlParser;

    public function __construct()
    {
        $this->yamlParser = new Yaml();
    }

    public function parse(string $content) : Document
    {
        // Parser regex borrowed from the `devster/frontmatter` package
        // https://github.com/devster/frontmatter/blob/bb5d2c7/src/Parser.php#L123
        $pattern = "/^\s*(?:---)[\n\r\s]*(.*?)[\n\r\s]*(?:---)[\s\n\r]*(.*)$/s";

        $parts = [];

        $match = preg_match($pattern, $content, $parts);

        if ($match === false) {
            throw new Exception('An error occurred while extracting the front matter from the contents');
        }

        if ($match === 0) {
            return new Document([], $content);
        }

        $matter = $this->yamlParser->parse($parts[1]);
        $body = $parts[2];

        return new Document($matter, $body);
    }
}
