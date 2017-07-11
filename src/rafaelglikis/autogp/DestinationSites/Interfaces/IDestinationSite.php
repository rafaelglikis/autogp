<?php
namespace rafaelglikis\autogp\DestinationSites\Interfaces;

interface IDestinationSite
{
    public function insertPublishedPost(string $title, string $content, string $imageUrl, $categoryIds);
    public function insertDraftPost(string $title, string $content, string $imageUrl, $categoryIds);
}