<?php

namespace rafaelglikis\autogp\Scrapers\Interfaces;


interface LastPost
{
    public function extractLastArticleFromCategory($categoryUrl): string;
}