<?php
namespace rafaelglikis\autogp\Scrapers;
use rafaelglikis\autogp\Datatypes\Article;
use rafaelglikis\autogp\Helpers\HtmlHelper;

abstract class ArticleScraper
{
    private $articleUrls = array();
    private $articles = array();
    private $categoryUrls = array();

    public function extractArticles()
    {
        foreach ($this->getCategoryUrls() as $categoryUrl) {
            $this->addArticleUrl($this->extractLastArticleFromCategory($categoryUrl));
        }

        foreach ($this->getArticleUrls() as $articleUrl) {
            $this->addArticle($this->extractArticle($articleUrl));
        }
    }

    abstract public static function extractLastArticleFromCategory($categoryUrl): string;

    public function extractArticle(string $url): Article
    {
        $html = HtmlHelper::getHtmlFrom($url);
        $article = new Article();

        $article->setSourceUrl($url);
        $article->setSourceSite(HtmlHelper::clearLink($url));
        $article->setHtml($html);

        $article->setTitle($this->extractTitle($html));
        $article->setImgUrl($this->extractMainImageUrl($html));
        $article->setContent($this->extractMainContent($html));

        return $article;
    }

    public function extractTitle(string $html): string
    {
        return HtmlHelper::findTitle($html);
    }

    public function extractMainImageUrl(string $html): string
    {
        return HtmlHelper::findMainImage($html);
    }

    public function extractMainContent(string $html): string
    {
        return HtmlHelper::findMainContent($html);
    }

    /***************************************************************
     *                      ADDERS - GETTERS
     ***************************************************************/

    public function addArticleUrl(string $articleUrl)
    {
        $this->articleUrls[] = $articleUrl;
    }

    public function getArticleUrls(): array
    {
        return $this->articleUrls;
    }

    public function addArticle(Article $article)
    {
        $this->articles[] = $article;
    }

    public function getArticles(): array
    {
        return $this->articles;
    }

    public function addCategory(string $category)
    {
        $this->categoryUrls[] = $category;
    }

    public function getCategoryUrls(): array
    {
        return $this->categoryUrls;
    }
}