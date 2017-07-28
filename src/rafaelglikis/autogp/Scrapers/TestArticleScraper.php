<?php

namespace rafaelglikis\autogp\Scrapers;
use rafaelglikis\autogp\Helpers\HtmlHelper;
use rafaelglikis\autogp\Helpers\TextHelper;

class TestArticleScraper extends ArticleScraper
{
    public function extractLastArticleFromCategory($categoryUrl): string
    {
        $html = HtmlHelper::getHtmlFrom("$categoryUrl");
        $aTag = TextHelper::strCut($html, "<p class=\"story-body__read-full-article\">", "</p>");

        $articleUrl = HtmlHelper::extractLink($aTag);

        return $articleUrl;
    }
}