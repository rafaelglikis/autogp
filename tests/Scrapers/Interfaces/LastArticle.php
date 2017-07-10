<?php
namespace rafaelglikis\autogp\Scrapers\Interfaces;

interface LastArticleScraper
{
    public static function extractLastArticleFromCategory($categoryUrl): string;
}