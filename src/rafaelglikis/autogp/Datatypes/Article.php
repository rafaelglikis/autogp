<?php
namespace rafaelglikis\autogp\Datatypes;

class Article
{
    private $sourceUrl;
    private $sourceSite;
    private $html;

    private $title;
    private $content;
    private $imgUrl;

    public function getSourceUrl(): string
    {
        return $this->sourceUrl;
    }

    public function setSourceUrl(string $sourceUrl)
    {
        $this->sourceUrl = $sourceUrl;
    }

    public function getSourceSite(): string
    {
        return $this->sourceSite;
    }

    public function setSourceSite(string $sourceSite)
    {
        $this->sourceSite = $sourceSite;
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

    /**
     * @return mixed
     */
    public function getHtml()
    {
        return $this->html;
    }

    /**
     * @param mixed $html
     */
    public function setHtml($html)
    {
        $this->html = $html;
    }
}