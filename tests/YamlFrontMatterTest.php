<?php

namespace Spatie\YamlFrontMatter\Tests;

use PHPUnit\Framework\TestCase;
use Spatie\YamlFrontMatter\Document;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class YamlFrontMatterTest extends TestCase
{
    /**
     * @dataProvider documentProvider
     */
    public function testParseFrontMatter($contents, $expectedMatter, $expectedBody)
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
                ['Lorem ipsum.']
            ],
            // Invalid front matter
            [
                "---\nfoo: bar\n--\n\nLorem ipsum.",
                [],
                [
                    'foo: bar',
                    'Lorem ipsum.'
                ]
            ],
            // Empty body
            [
                "---\nfoo: bar\n---\n",
                ['foo' => 'bar'],
                []
            ]
        ];
    }

    public function testParseFrontMatterFromFile()
    {
        $document = YamlFrontMatter::parseFile(__DIR__.'/document.md');

        $this->assertInstanceOf(Document::class, $document);
        $this->assertEquals(['foo' => 'bar'], $document->matter());
        $this->assertContains("Lorem ipsum.", $document->body());
    }
}
