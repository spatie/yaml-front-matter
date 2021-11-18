<?php

namespace Spatie\YamlFrontMatter\Tests;

use ArrayAccess;
use PHPUnit\Framework\TestCase;
use Spatie\YamlFrontMatter\Arr;

class ArrTest extends TestCase
{
    protected $testArray;

    public function setUp(): void
    {
        $this->testArray = [
            'title' => 'Front Matter',
            'meta'  => ['date' => '01/02/1992'],
            'body'  => 'Hello world!',
        ];
    }

    /** @test */
    public function it_can_return_a_single_value()
    {
        $arrayAccessObject = $this->createMock(ArrayAccess::class);
        $arrayAccessObject->method('offsetExists')
            ->with('title')
            ->willReturn(true);

        $arrayAccessObject->method('offsetGet')
            ->with('title')
            ->willReturn('Front Matter');

        $this->assertEquals('Front Matter', Arr::get($this->testArray, 'title'));
        $this->assertEquals('Front Matter', Arr::get($arrayAccessObject, 'title'));
    }

    /** @test */
    public function it_supports_nested_notation()
    {
        $this->assertEquals('01/02/1992', Arr::get($this->testArray, 'meta.date'));
    }

    /** @test */
    public function it_can_return_a_default_value_if_dot_notation_key_doesnt_exist()
    {
        $this->assertEquals('technology', Arr::get($this->testArray, 'meta.keywords', 'technology'));
    }

    /** @test */
    public function it_can_return_a_default_value_if_an_array_is_not_passed()
    {
        $this->assertEquals('technology', Arr::get('not_array', 'title', 'technology'));
    }

    /** @test */
    public function it_returns_array_if_key_is_null()
    {
        $this->assertEquals($this->testArray, Arr::get($this->testArray, null));
    }
}
