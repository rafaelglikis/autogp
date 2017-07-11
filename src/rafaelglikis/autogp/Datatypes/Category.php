<?php
namespace rafaelglikis\autogp\Datatypes;

class Category
{
    protected $sourceUrl;

    public function __construct(string $sourceUrl)
    {
        $this->sourceUrl = $sourceUrl;
    }

    public function getSourceUrl(): string
    {
        return $this->sourceUrl;
    }

    public function setSourceUrl(string $sourceUrl)
    {
        $this->sourceUrl = $sourceUrl;
    }
}