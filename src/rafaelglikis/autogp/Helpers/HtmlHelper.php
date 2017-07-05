<?php
namespace rafaelglikis\autogp\Helpers;

use DOMDocument;

class HtmlHelper
{
    // Heuristics
    const SPECIAL_CLASS_NAME_SCORE = 25;
    const IRRELEVANT_CLASS_NAME_SCORE = -50;
    const SPECIAL_ID_NAME_SCORE = 25;
    const IRRELEVANT_ID_NAME_SCORE = -50;

    // Regular Expressions
    const IRRELEVANT_ID_REGEX = "/(comment|meta|footer|footnote)/i";
    const SPECIAL_ID_REGEX = "/((^|\\s)(post|hentry|entry[-]?(content|text|body)?|article[-]?(content|text|body)?)(\\s|$))/i";
    const IRRELEVANT_CLASS_REGEX = "/(comment|meta|footer|footnote)/i";
    const SPECIAL_CLASS_REGEX = "/^(post|hentry|entry[-]?(content|text|body)?|article[-]?(content|text|body)?)$/i";


    /**
     * Takes the html from file or from Url
     * @param $source
     * @return string
     */
    public static function getHtmlFrom($source)
    {
        return file_get_contents($source);
    }

    public static function curl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    /**
     * Remove unnecessary html tags
     * (scripts, styles, ads, etc)
     * @param $html
     * @return string
     */
    public static function fixHtml($html)
    {
        $html = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $html);
        $html = preg_replace('#<style(.*?)>(.*?)</style>#is', '', $html);
        $html = strip_tags($html, '<p><strong><a><iframe><img><ul><ol><li><br><h1><h2><h3><h4>');

        return $html;
    }

    /**
     * Finds the title of the given html page
     * @param $html
     * @return string
     */
    public static function findTitle($html)
    {
        $doc = new DOMDocument();
        @$doc->loadHTML($html);
        $nodes = $doc->getElementsByTagName('title');

        $title = $nodes->item(0)->nodeValue;

        return $title;
    }

    /**
     * Finds the main image of the given html page
     * @param $html
     * @return string
     */
    public static function findMainImage($html)
    {
        $doc = new DOMDocument();
        @$doc->loadHTML($html);

        $metas = $doc->getElementsByTagName('meta');

        for ($i = 0; $i < $metas->length; $i++)
        {
            $meta = $metas->item($i);
            if ($meta->getAttribute('property') == 'og:image')
            {
                return $meta->getAttribute('content');
            }
        }
        return null;
    }

    /**
     * Extracts image from given html
     * TODO use regex to do that and extract multible
     * @param $html
     * @return null|string
     */
    private static function extractImage($html)
    {
        $html = strip_tags($html, '<a><img>');
        $url = TextHelper::strCut($html, 'href="', '"');

        return $url;
    }

    /**
     * Extracts link from given html
     * TODO use regex to do that and extract multible
     * @param $html
     * @return null|string
     */
    private static function extractLink($html)
    {
        $html = strip_tags($html, '<a>');
        $url = null;

        if (strpos($html, "href='") !== false)
        {
            $url = TextHelper::strCut($html, "href='", "'");
        }

        if (strpos($html, 'href="') !== false)
        {
            $url = TextHelper::strCut($html, 'href="', '"');
        }

        return $url;
    }

    /**
     * Leaves only the necessary part of the link
     * @param $url
     * @return mixed
     */
    public static function clearLink($url)
    {
        $url = str_replace('https://www.', '', $url);
        $url = str_replace('http://www.', '', $url);
        $url = str_replace('https://', '', $url);
        $url = str_replace('http://', '', $url);

        return $url;
    }

    /**
     * Finds the main content of the given html code
     * (Uses Heuristic not 100% accurate)
     * @param $html
     * @return string
     */
    public static function findMainContent($html)
    {
        $mainContentNode = HtmlHelper::findTopNode($html);

        // DOMDocument
        $Target = new DOMDocument;
        $Target->appendChild($Target->importNode($mainContentNode, true));

        $mainContent = $Target->saveHTML();
        $mainContent = HtmlHelper::fixHtml($mainContent);

        return $mainContent;
    }

    /**
     * Finds the main node of given html.
     * (Uses Heuristic not 100% accurate)
     * @param $html
     * @return mixed|null
     */
    private static function findTopNode($html)
    {
        $dom = new DOMDocument();
        @$dom->loadHTML($html);

        // Study all the paragraphs and calculate the score of parentNode
        // Score is determined by heuristics.
        $nodes = array();
        $paragraphs = $dom->getElementsByTagName("p");
        foreach ($paragraphs as $paragraph)
        {
            $contentScore = HtmlHelper::calculateParagraphScore($paragraph);
            $paragraph->parentNode->setAttribute("contentScore", $contentScore);
            $nodes[] = $paragraph->parentNode;
        }

        // Find the node with the higher score
        $topNode = $nodes[0];
        foreach ($nodes as $node)
        {
            $contentScore = intval($node->getAttribute("contentScore"));
            $higherContentScore = intval($topNode->getAttribute("contentScore"));

            if ($contentScore && $contentScore > $higherContentScore) {
                $topNode = $node;
            }
        }

        return $topNode;
    }

    /**
     * Calculates the score of the given paragraph.
     * Score is determined by heuristics.
     * @param $paragraph
     * @return int
     */
    private static function calculateParagraphScore($paragraph)
    {
        $parentNode = $paragraph->parentNode;

        $contentScore = intval($parentNode->getAttribute("contentScore"));

        // Look for a special classname
        $className = $parentNode->getAttribute("class");
        if (preg_match(HtmlHelper::IRRELEVANT_ID_REGEX, $className)) {
            $contentScore += HtmlHelper::IRRELEVANT_CLASS_NAME_SCORE;
        } else if(preg_match(HtmlHelper::SPECIAL_ID_REGEX, $className)) {
            $contentScore += HtmlHelper::SPECIAL_CLASS_NAME_SCORE;
        }

        // Look for a special ID
        $id = $parentNode->getAttribute("id");
        if (preg_match(HtmlHelper::IRRELEVANT_CLASS_REGEX, $id)) {
            $contentScore += HtmlHelper::IRRELEVANT_ID_NAME_SCORE;
        } else if (preg_match(HtmlHelper::SPECIAL_CLASS_REGEX, $id)) {
            $contentScore += HtmlHelper::SPECIAL_ID_NAME_SCORE;
        }

        // Add paragraph length to score
        if (strlen($paragraph->nodeValue) > 10) {
            $contentScore += strlen($paragraph->nodeValue);
        }

        return $contentScore;
    }
}