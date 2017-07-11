<?php

namespace rafaelglikis\autogp\DestinationSites;
use rafaelglikis\autogp\DestinationSites\Interfaces\IDestinationSite;


abstract class DestinationSite implements IDestinationSite
{
    abstract public function insertPublishedPost(string $title, string $content, string $imageUrl, $categoryIds = null);
    abstract public function insertDraftPost(string $title, string $content, string $imageUrl, $categoryIds);
}