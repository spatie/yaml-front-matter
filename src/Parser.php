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
        $pattern = '/[\s\r\n]---[\s\r\n]/s';

        $parts = preg_split($pattern, PHP_EOL . ltrim($content));

        if (count($parts) < 3) {
            return new Document([], $content);
        }
        $matter = $this->yamlParser->parse(trim($parts[1]));
        $body = implode(PHP_EOL . "---" . PHP_EOL, array_slice($parts, 2));
        return new Document($matter, $body);
    }

}
