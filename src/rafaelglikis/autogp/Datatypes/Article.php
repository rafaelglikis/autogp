<?php

class Article
{
    private $source_url;
    private $source_site;

    private $title;
    private $content;
    private $imgUrl;

    public function getSourceUrl(): string
    {
        return $this->source_url;
    }

    public function setSourceUrl(string $source_url)
    {
        $this->source_url = $source_url;
    }

    public function getSourceSite(): string
    {
        return $this->source_site;
    }

    public function setSourceSite(string $source_site)
    {
        $this->source_site = $source_site;
    }

    public function getTitle() : string
    {
        return $this->title;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content)
    {
        $this->content = $content;
    }

    public function getImgUrl(): string
    {
        return $this->imgUrl;
    }

    public function setImgUrl(string $imgUrl)
    {
        $this->imgUrl = $imgUrl;
    }
}