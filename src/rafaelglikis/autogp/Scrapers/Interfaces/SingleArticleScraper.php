<?php
namespace rafaelglikis\autogp\Scrapers\Interfaces;

interface SingleArticleScraper
{
    public function extractTitle(string $html): string;
    public function extractMainImageUrl(string $html): string;
    public function extractMainContent(string $html): string;
}