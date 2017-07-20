<?php

namespace rafaelglikis\autogp\Copiers;
use rafaelglikis\autogp\Datatypes\CopierCategory;
use rafaelglikis\autogp\DestinationSites\DestinationSite;
use rafaelglikis\autogp\Scrapers\ArticleScraper;
use rafaelglikis\autogp\Databases\CopierDatabase;

class Copier
{
    protected $copierName;
    protected $dbName;
    protected $destinationSite;
    protected $database;
    protected $sourceSiteScraper;
    protected $categories = array();

    function __construct(string $copierName, ArticleScraper $sourceSiteScraper, DestinationSite $destinationSite)
    {
        $this->copierName = $copierName;
        $this->sourceSiteScraper = $sourceSiteScraper;
        $this->destinationSite = $destinationSite;
        $this->database = new CopierDatabase($this->copierName);
    }

    function update($publish = true)
    {
        print "-------------------------------------------\n";
        print " " . $this->getCopierName() . " update\n";
        print "-------------------------------------------\n";

        /** @var CopierCategory $category */
        foreach ($this->categories as $category)
        {
            $articleUrl = $this->sourceSiteScraper->extractLastArticleFromCategory($category->getSourceUrl());
            if($this->database->recordExist($articleUrl)) {
                print "[i] Article: $articleUrl already exist \n";
            }
            else
            {
                $this->database->
                insertRecordValue($articleUrl);

                $article = $this->sourceSiteScraper->extractArticle($articleUrl);
                $categories = $category->getDestinationCategories();

                if ($publish) {
                    $this->destinationSite->insertPublishedArticle($article, $categories);
                } else {
                    $this->destinationSite->insertDraftArticle($article, $categories);
                }
            }
        }

        $this->sourceSiteScraper->extractArticles();

        foreach ($this->sourceSiteScraper->getArticles() as $article) {
            if ($publish) {
                $this->destinationSite->insertPublishedArticle($article);
            } else {
                $this->destinationSite->insertDraftArticle($article);
            }
        }
    }

    /***************************************************************
     *                      ADDERS - GETTERS
     ***************************************************************/

    function addCategory(CopierCategory $copierCategory)
    {
        $this->categories[] = $copierCategory;
    }


    public function getCategories(): array
    {
        return $this->categories;
    }

    public function setCategories(array $categories)
    {
        $this->categories = $categories;
    }

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