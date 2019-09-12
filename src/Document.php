<?php

namespace Spatie\YamlFrontMatter;

class Document
{
    protected $matter;
    protected $body;

    public function __construct($matter, string $body)
    {
        $this->matter = is_array($matter) ? $matter : [];
        $this->body = $body;
    }

    public function matter(string $key = null, $default = null)
    {
        if ($key) {
            return Arr::get($this->matter, $key, $default);
        }

        return $this->matter;
    }

    public function body() : string
    {
        return $this->body;
    }

    public function __get($key)
    {
        return $this->matter($key);
    }
}
