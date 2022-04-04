<?php

namespace Spatie\YamlFrontMatter;

use Symfony\Component\Yaml\Yaml;

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
class ComplexMarkdownParser
{
    /**
     * The Markdown content
     * @var string
     */
    protected $content;

    /**
     * The document string as an array of lines,
     * making it easier to understand and work with.
     * @var array
     */
    protected $lines;

    /**
     * The line number of the starting front matter control block
     * @var int|null
     */
    public $frontMatterStartLine;

    /**
     * The line number of the ending front matter control block
     * @var int|null
     */
    public $frontMatterEndLine;

    public function __construct(string $content)
    {
        $this->content = $content;
        $this->lines = explode("\n", $this->content);
    }

    /**
     * A parser that can handle Markdown that contains Markdown.
     * @return Document
     */
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

    /**
     * Is a given line a front matter control block?
     *
     * A control block is a line that starts with three dashes.
     * @param string $line
     * @return bool
     */
    private function isFrontMatterControlBlock(string $line): bool
    {
        return substr($line, 0, 3) === '---';
    }


    /**
     * Find the line numbers of the front matter start and end blocks.
     */
    private function findFrontMatterStartAndEndLineNumbers()
    {
        foreach ($this->lines as $lineNumber => $lineContents) {
            if ($this->isFrontMatterControlBlock($lineContents)) {
                $this->setFrontMatterLineNumber($lineNumber);
            }
        }
    }

    /**
     * Find and set the line numbers of the front matter start and end blocks.
     *
     * Ignores any additional front matter blocks found later in the document.
     * @param $lineNumber
     * @return void
     */
    private function setFrontMatterLineNumber($lineNumber)
    {
        if (!isset($this->frontMatterStartLine)) {
            $this->frontMatterStartLine = $lineNumber;
            return;
        }
        if (!isset($this->frontMatterEndLine)) {
            $this->frontMatterEndLine = $lineNumber;
        }
    }

    /**
     * Does the current document have front matter?
     * @return bool
     */
    private function hasFrontMatter(): bool
    {
        return $this->frontMatterStartLine !== null && $this->frontMatterEndLine !== null;
    }

    /**
     * Get the front matter from the document.
     *
     * Works by collecting all the lines before the end block,
     * while skipping over the actual control blocks.
     * @return string
     */
    private function getFrontMatter(): string
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

    /**
     * Get the body of the document.
     *
     * Works by collecting all the lines after the end block.
     * @return string
     */
    private function getBody(): string
    {
        $body = [];
        foreach ($this->lines as $lineNumber => $lineContents) {
            if ($lineNumber > $this->frontMatterEndLine) {
                $body[] = $lineContents;
            }
        }
        return implode("\n", $this->trimBody($body));
    }

    /**
     * If the first line of the body is empty, remove it
     * @param array $body
     * @return array
     */
    private function trimBody(array $body): array
    {
        if (trim($body[0]) === '') {
            unset($body[0]);
        }
        return $body;
    }
}
