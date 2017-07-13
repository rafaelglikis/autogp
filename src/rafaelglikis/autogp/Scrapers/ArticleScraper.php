<?php
namespace rafaelglikis\autogp\Scrapers;

use rafaelglikis\autogp\Datatypes\Article;
use rafaelglikis\autogp\Datatypes\Category;
use rafaelglikis\autogp\Datatypes\CopierCategory;
use rafaelglikis\autogp\Helpers\HtmlHelper;
use rafaelglikis\autogp\Scrapers\Interfaces\LastPost;
use rafaelglikis\autogp\Scrapers\Interfaces\SingleArticleScraper;

abstract class ArticleScraper implements SingleArticleScraper, LastPost
{
    private $articleUrls = array();
    private $articles = array();
    private $categories = array();

    public function extractArticles(): array
    {
        foreach ($this->getCategories() as $category)
        {
            $articleUrl = $this->extractLastArticleFromCategory($category->getSourceUrl());
            $article = $this->extractArticle($articleUrl);
            $this->addArticle($article);
        }

        foreach ($this->getArticleUrls() as $articleUrl)
        {
            $article = $this->extractArticle($articleUrl);
            $this->addArticle($article);
        }

        return $this->articles;
    }

    public function extractArticleUrls(): array
    {
        foreach ($this->getCategories() as $category)
        {
            $articleUrl = $this->extractLastArticleFromCategory($category->getSourceUrl());
            $this->articleUrls[] =  $articleUrl;

        }
        return $this->articleUrls;
    }

    abstract public function extractLastArticleFromCategory($categoryUrl): string;

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

    public function addCategory(Category $category)
    {
        $this->categories[] = $category;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function setCategories(array $categories)
    {
        $this->categories = $categories;
    }
}