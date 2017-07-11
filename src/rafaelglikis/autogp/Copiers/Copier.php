<?php

namespace rafaelglikis\autogp\Copiers;
use rafaelglikis\autogp\Datatypes\Article;
use rafaelglikis\autogp\DestinationSites\DestinationSite;
use rafaelglikis\autogp\Scrapers\ArticleScraper;

class Copier
{
    protected $copierName;
    protected $dbName;
    protected $destinationSite;
    protected $sourceSiteScraper;

    function __construct(string $copierName, ArticleScraper $sourceSiteScraper, DestinationSite $destinationSite)
    {
        $this->copierName = $copierName;
        $this->sourceSiteScraper = $sourceSiteScraper;
        $this->destinationSite = $destinationSite;
    }

    function update()
    {
        print "-------------------------------------------\n";
        print " " . $this->getCopierName() . " update\n";
        print "-------------------------------------------\n";

        $articles = $this->sourceSiteScraper->extractArticles();

        foreach ($articles as $article)
        {
            /* @var $article Article */
            $title = $article->getTitle();
            $image = $article->getImgUrl();
            $content = $article->getContent();
            $categories = $article->getDestinationCategories();

            if(sizeof($categories)===0) {
                $this->destinationSite->insertPublishedPost($title, $image, $content);
            } else {
                $this->destinationSite->insertPublishedPost($title, $image, $content, $categories);
            }
        }
    }

    /*
     * *************************************************
     *                   SETTERS GETTERS
     * *************************************************
     */

    public function setCopierCategories(array $copierCategories)
    {
        $this->copierCategories = $copierCategories;
    }

    public function getCopierName(): string
    {
        return $this->copierName;
    }

    public function setCopierName(string $copierName)
    {
        $this->copierName = $copierName;
    }

    public function getDbName(): string
    {
        return $this->dbName;
    }

    public function setDbName(string $dbName)
    {
        $this->dbName = $dbName;
    }

    public function getDestinationSite(): DestinationSite
    {
        return $this->destinationSite;
    }

    public function setDestinationSite(DestinationSite $destinationSite)
    {
        $this->destinationSite = $destinationSite;
    }

    public function getSourceSiteScraper(): ArticleScraper
    {
        return $this->sourceSiteScraper;
    }

    public function setSourceSiteScraper(ArticleScraper $sourceSiteScraper)
    {
        $this->sourceSiteScraper = $sourceSiteScraper;
    }


}