<?php

namespace Spatie\YamlFrontMatter\Tests;

use PHPUnit\Framework\TestCase;
use Spatie\YamlFrontMatter\Document;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class YamlFrontMatterTest extends TestCase
{
    /**
     * @test
     * @dataProvider documentProvider
     */
    public function it_can_parse_front_matter($contents, $expectedMatter, $expectedBody)
    {
        $document = YamlFrontMatter::parse($contents);

        $this->assertInstanceOf(Document::class, $document);

        $this->assertEquals($expectedMatter, $document->matter());

        foreach ($expectedBody as $str) {
            $this->assertContains($str, $document->body());
        }

        if (empty($expectedBody)) {
            $this->assertEmpty($document->body());
        }
    }

    public function documentProvider()
    {
        return [
            // Valid front matter
            [
                "---\nfoo: bar\n---\n\nLorem ipsum.",
                ['foo' => 'bar'],
                ['Lorem ipsum.'],
            ],
            // Invalid front matter
            [
                "---\nfoo: bar\n--\n\nLorem ipsum.",
                [],
                [
                    'foo: bar',
                    'Lorem ipsum.',
                ],
            ],
            // Empty body
            [
                "---\nfoo: bar\n---\n",
                ['foo' => 'bar'],
                [],
            ],
            // No newline
            [
                "---\nfoo: bar\n---",
                ['foo' => 'bar'],
                [],
            ],
            // Delimiter in matter
            [
                "---\nfoo: ---bar\n---",
                ['foo' => '---bar'],
                [],
            ],
        ];
    }

    /** @test */
    public function it_can_parse_front_matter_from_a_file()
    {
        $document = YamlFrontMatter::parseFile(__DIR__.'/document.md');

        $this->assertInstanceOf(Document::class, $document);
        $this->assertEquals(['foo' => 'bar'], $document->matter());
        $this->assertContains('Lorem ipsum.', $document->body());
    }
}
