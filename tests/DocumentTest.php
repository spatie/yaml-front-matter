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

    /** @test */
    public function it_cant_return_all_front_matter()
    {
        $matter = $this->document->matter();

        $this->assertArrayHasKey('title', $matter);
        $this->assertEquals('Front Matter', $matter['title']);

        $this->assertArrayHasKey('meta', $matter);
        $this->assertEquals(['date' => '01/02/1992'], $matter['meta']);
    }

    /** @test */
    public function it_can_return_specific_front_matter()
    {
        $this->assertEquals('Front Matter', $this->document->matter('title'));
    }

    /** @test */
    public function it_can_return_nested_front_matter()
    {
        $this->assertEquals('01/02/1992', $this->document->matter('meta.date'));
    }

    /** @test */
    public function it_can_return_a_default_front_matter_value()
    {
        $this->assertEquals('technology', $this->document->matter('keywords', 'technology'));
    }

    /** @test */
    public function it_can_return_the_body()
    {
        $this->assertEquals('Hello world!', $this->document->body());
    }

    /** @test */
    public function it_can_magically_get_specific_front_matter()
    {
        $this->assertEquals("Front Matter", $this->document->title);
    }
}
