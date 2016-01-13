<?php

namespace spec\Spatie\YamlFrontMatter;

use PhpSpec\ObjectBehavior;
use Spatie\YamlFrontMatter\YamlFrontMatterObject;
use Spatie\YamlFrontMatter\YamlFrontMatterParser;

class YamlFrontMatterParserSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(YamlFrontMatterParser::class);
    }

    public function it_can_parse_valid_front_matter()
    {
        $contents = "
        ---
        foo: bar
        ---

        Lorem ipsum.
        ";

        $this->parse($contents)->shouldHaveType(YamlFrontMatterObject::class);
        $this->parse($contents)->shouldHaveFrontMatter(['foo' => 'bar']);
        $this->parse($contents)->shouldHaveBodyContaining('Lorem ipsum.');
    }

    public function it_falls_back_to_empty_front_matter_with_the_original_as_body()
    {
        $contents = "
        ---
        foo: bar
        --

        Lorem ipsum.
        ";

        $this->parse($contents)->shouldHaveType(YamlFrontMatterObject::class);
        $this->parse($contents)->shouldHaveFrontMatter([]);
        $this->parse($contents)->shouldHaveBodyContaining('foo: bar');
        $this->parse($contents)->shouldHaveBodyContaining('Lorem ipsum.');
    }

    public function getMatchers() : array
    {
        return [
            'haveFrontMatter' => function (YamlFrontMatterObject $subject, $value) {
                return $subject->matter() === $value;
            },
            'haveBodyContaining' => function (YamlFrontMatterObject $subject, $value) {
                return str_contains($subject->body(), $value);
            },
        ];
    }
}
