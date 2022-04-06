<?php

namespace Spatie\YamlFrontMatter;

use Symfony\Component\Yaml\Yaml;

class ComplexMarkdownParser
{
    protected $content;
    protected $lines;

    public $frontMatterStartLine;
    public $frontMatterEndLine;

    public function __construct(string $content)
    {
        $this->content = $content;
        $this->lines = explode("\n", $this->content);
    }

    public function parse(): Document
    {
        $this->findFrontMatterStartAndEndLineNumbers();

        if (!$this->hasFrontMatter()) {
            return new Document([], $this->content);
        }

        $matter = $this->getFrontMatter();
        $body = $this->getBody();

        $matter = Yaml::parse($matter);

        return new Document($matter, $body);
    }

    protected function findFrontMatterStartAndEndLineNumbers()
    {
        foreach ($this->lines as $lineNumber => $lineContents) {
            if ($this->isFrontMatterControlBlock($lineContents)) {
                $this->setFrontMatterLineNumber($lineNumber);
            }
        }
    }

    protected function setFrontMatterLineNumber(int $lineNumber)
    {
        if (!isset($this->frontMatterStartLine)) {
            $this->frontMatterStartLine = $lineNumber;
            return;
        }

        if (!isset($this->frontMatterEndLine)) {
            $this->frontMatterEndLine = $lineNumber;
        }
    }

    protected function getFrontMatter(): string
    {
        $matter = [];
        foreach ($this->lines as $lineNumber => $lineContents) {
            if ($lineNumber <= $this->frontMatterEndLine) {
                if (!$this->isFrontMatterControlBlock($lineContents)) {
                    $matter[] = $lineContents;
                }
            }
        }
        return implode("\n", $matter);
    }

    protected function getBody(): string
    {
        $body = [];
        foreach ($this->lines as $lineNumber => $lineContents) {
            if ($lineNumber > $this->frontMatterEndLine) {
                $body[] = $lineContents;
            }
        }
        return implode("\n", $this->trimBody($body));
    }

    protected function trimBody(array $body): array
    {
        if (trim($body[0]) === '') {
            unset($body[0]);
        }
        return $body;
    }

    protected function hasFrontMatter(): bool
    {
        return ($this->frontMatterStartLine !== null) && ($this->frontMatterEndLine !== null);
    }

    protected function isFrontMatterControlBlock(string $line): bool
    {
        return substr($line, 0, 3) === '---';
    }
}
