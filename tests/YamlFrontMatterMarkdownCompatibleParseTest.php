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
}
