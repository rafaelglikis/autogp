<?php
/**
 * Created by PhpStorm.
 * User: rafaelglikis
 * Date: 06/07/2017
 * Time: 5:02 ΜΜ
 */

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