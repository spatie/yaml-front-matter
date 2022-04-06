<?php

namespace Spatie\YamlFrontMatter\Tests;

use Spatie\YamlFrontMatter\Document;
use Spatie\YamlFrontMatter\YamlFrontMatter;
use PHPUnit\Framework\TestCase;

class YamlFrontMatterMarkdownCompatibleParseTest extends TestCase
{
    /** @test */
    public function it_can_parse_simple_front_matter_from_a_file()
    {
        $document = YamlFrontMatter::markdownCompatibleParse(
            file_get_contents(__DIR__.'/document.md')
        );

        $this->assertInstanceOf(Document::class, $document);
        $this->assertEquals(['foo' => 'bar'], $document->matter());
        $this->assertStringContainsString('Lorem ipsum.', $document->body());
    }

    /** @test */
    public function it_can_parse_complex_front_matter_from_a_file()
    {
        $document = YamlFrontMatter::markdownCompatibleParse(
            file_get_contents(__DIR__.'/meta-document.md')
        );

        $this->assertInstanceOf(Document::class, $document);
        $this->assertEquals(['foo' => 'bar'], $document->matter());
        $this->assertStringContainsString('Lorem ipsum.', $document->body());
    }

    /** @test */
    public function it_separates_the_front_matter_from_the_body()
    {
        $document = YamlFrontMatter::markdownCompatibleParse(
           "---\ntitle: Front Matter\n---\n\nLorem ipsum."
        );

        $this->assertInstanceOf(Document::class, $document);

        // This implicitly asserts that the front matter does not contain any markdown
        $this->assertEquals(['title' => 'Front Matter'], $document->matter());
        // This implicitly asserts that the body does not contain any front matter remnants
        $this->assertEquals('Lorem ipsum.', $document->body());
    }

    /** @test */
    public function it_leaves_string_without_front_matter_intact()
    {
        $document = YamlFrontMatter::markdownCompatibleParse(
            "Lorem ipsum."
        );

        $this->assertInstanceOf(Document::class, $document);
        $this->assertEmpty($document->matter());
        $this->assertEquals('Lorem ipsum.', $document->body());
    }

    /** @test */
    public function it_can_parse_a_file_partial_front_matter()
    {
        // If there is only one YAML control block, (---) the front matter is invalid
        // and the document should be interpreted as having no front matter.

        $document = YamlFrontMatter::markdownCompatibleParse(
           "---\ntitle: Front Matter\n\nLorem ipsum."
        );

        $this->assertInstanceOf(Document::class, $document);
        $this->assertEmpty($document->matter());
        $this->assertEquals("---\ntitle: Front Matter\n\nLorem ipsum.", $document->body());
    }

    /** @test */
    public function it_can_parse_a_string_with_unix_line_endings()
    {
        $document = YamlFrontMatter::markdownCompatibleParse(
           "---\nfoo: bar\n---\n\nLorem ipsum."
        );

        $this->assertInstanceOf(Document::class, $document);
        $this->assertEquals(['foo' => 'bar'], $document->matter());
        $this->assertStringContainsString('Lorem ipsum.', $document->body());
    }

    /** @test */
    public function it_can_parse_a_string_with_windows_line_endings()
    {
        $document = YamlFrontMatter::markdownCompatibleParse(
           "---\r\nfoo: bar\r\n---\r\n\r\nLorem ipsum."
        );

        $this->assertInstanceOf(Document::class, $document);
        $this->assertEquals(['foo' => 'bar'], $document->matter());
        $this->assertStringContainsString('Lorem ipsum.', $document->body());
    }
}
