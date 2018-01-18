<?php

namespace Spatie\YamlFrontMatter\Tests;

use PHPUnit\Framework\TestCase;
use Spatie\YamlFrontMatter\Document;

class DocumentTest extends TestCase
{
    protected $document;

    public function setUp()
    {
        $this->document = new \Spatie\YamlFrontMatter\Document(
            [
                'title' => 'Front Matter',
                'meta' => ['date' => '01/02/1992']
            ],
            'Hello world!'
        );
    }

    public function testReturnsAllFrontMatter()
    {
        $matter = $this->document->matter();

        $this->assertArrayHasKey('title', $matter);
        $this->assertEquals('Front Matter', $matter['title']);

        $this->assertArrayHasKey('meta', $matter);
        $this->assertEquals(['date' => '01/02/1992'], $matter['meta']);
    }

    public function testReturnSpecificFrontMatter()
    {
        $this->assertEquals('Front Matter', $this->document->matter('title'));
    }

    public function testReturnsNestedSpecificFrontMatter()
    {
        $this->assertEquals('01/02/1992', $this->document->matter('meta.date'));
    }

    public function testReturnsDefaultFrontMatterValue()
    {
        $this->assertEquals('technology', $this->document->matter('keywords', 'technology'));
    }

    public function testReturnsBody()
    {
        $this->assertEquals('Hello world!', $this->document->body());
    }

    public function testMagicallyGetSpecificFrontMatter()
    {
        $this->assertEquals("Front Matter", $this->document->title);
    }
}
