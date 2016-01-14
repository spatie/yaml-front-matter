<?php

namespace spec\Spatie\YamlFrontMatter;

use PhpSpec\ObjectBehavior;
use Spatie\YamlFrontMatter\Document;

class DocumentSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(
            [
                'title' => 'Front Matter',
                'meta' => ['date' => '01/02/1992']
            ],
            'Hello world!'
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Document::class);
    }

    public function it_returns_all_front_matter()
    {
        $this->matter()->shouldHaveKeyWithValue('title', 'Front Matter');
        $this->matter()->shouldHaveKeyWithValue('meta', ['date' => '01/02/1992']);
    }

    public function it_returns_specific_front_matter()
    {
        $this->matter('title')->shouldBe('Front Matter');
    }

    public function it_returns_nested_specific_front_matter()
    {
        $this->matter('meta.date')->shouldBe('01/02/1992');
    }

    public function it_can_fall_back_to_a_default_for_front_matter()
    {
        $this->matter('keywords', 'technology')->shouldBe('technology');
    }

    public function it_returns_the_body()
    {
        $this->body()->shouldBe('Hello world!');
    }
}
