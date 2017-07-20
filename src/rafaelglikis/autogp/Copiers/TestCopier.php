<?php

namespace rafaelglikis\autogp\Copiers;

use rafaelglikis\autogp\DestinationSites\DestinationSite;
use rafaelglikis\autogp\Scrapers\ArticleScraper;

class TestCopier extends Copier
{
    function __construct(string $copierName, ArticleScraper $sourceSiteScraper, DestinationSite $destinationSite)
    {
        parent::__construct($copierName, $sourceSiteScraper, $destinationSite);
    }

    function update($publish = true)
    {
        parent::update($publish);
        return true;
    }
}