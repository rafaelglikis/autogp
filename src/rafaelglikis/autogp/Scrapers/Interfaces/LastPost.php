<?php

namespace rafaelglikis\autogp\Scrapers\Interfaces;


interface LastPost
{
    public static function extractLastArticleFromCategory($categoryUrl): string;
}