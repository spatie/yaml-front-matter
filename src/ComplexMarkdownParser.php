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
     * The document string as an array of lines
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
        // Turn the string into an array of lines, making the code easier to understand
        $this->lines = explode("\n", $this->content);
    }

    /**
     * A parser that can handle Markdown that contains Markdown.
     * @return Document
     */
    public function parse(): Document
    {
        // Find the line numbers of the front matter start and end blocks
        $this->findFrontMatterStartAndEndLineNumbers();

        // If there are no front matter blocks, we just return the content as is
        if (!$this->hasFrontMatter()) {
            return new Document([], $this->content);
        }

        // Construct the new line arrays
        $matter = [];
        $body = [];

        // Loop through the original line array
        foreach ($this->lines as $lineNumber => $lineContents) {
            // Compare the line number to the one of the closing front matter block
            // to determine if we're in the front matter or the body
            if ($lineNumber <= $this->frontMatterEndLine) {
                $matter[] = $lineContents;
            } else {
                $body[] = $lineContents;
            }
        }

        // Remove the dashes
        unset($matter[$this->frontMatterStartLine]);
        unset($matter[$this->frontMatterEndLine]);

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

    /**
     * Is a given line a front matter control block?
     *
     * A control block is a line that starts with three dashes.
     *
     * @param string $line
     * @return bool
     */
    private function isFrontMatterControlBlock(string $line): bool
    {
        return substr($line, 0, 3) === '---';
    }

    /**
     * Does the current document have front matter?
     * @return bool
     */
    private function hasFrontMatter(): bool
    {
        return $this->frontMatterStartLine !== null && $this->frontMatterEndLine !== null;
    }

    private function findFrontMatterStartAndEndLineNumbers()
    {
        foreach ($this->lines as $lineNumber => $lineContents) {
            // If the line starts with three dashes, it's a front matter control block
            if ($this->isFrontMatterControlBlock($lineContents)) {
                // The line contains the front matter control block
                if (!isset($this->frontMatterStartLine)) {
                    // This is the first control block
                    $this->frontMatterStartLine = $lineNumber;
                } elseif (!isset($this->frontMatterEndLine)) {
                    // This is the second control block
                    $this->frontMatterEndLine = $lineNumber;
                    // We can now break the loop because we found the end of the actual front matter
                    break;
                }
            }
        }
    }
}
