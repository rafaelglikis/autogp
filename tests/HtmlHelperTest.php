<?php

use PHPUnit\Framework\TestCase;
use rafaelglikis\autogp\Helpers\HtmlHelper;

class HtmlHelperTest extends TestCase
{
    private static $html;

    public static function setUpBeforeClass()
    {
        HtmlHelperTest::$html = HtmlHelper::getHtmlFrom("samples/test.html");
    }

    public function testFindTitle()
    {
        $result = HtmlHelper::findTitle(HtmlHelperTest::$html);
        $expected_result = "Why people believe the myth of 'plastic rice' - BBC News";

        $this->assertEquals($result, $expected_result);
    }

    public function testFindMainImage()
    {
        $result = HtmlHelper::findMainImage(HtmlHelperTest::$html);
        $expected_result = "https://ichef.bbci.co.uk/news/1024/cpsprodpb/8688/production/_96804443_riceball3.jpg";

        $this->assertEquals($result, $expected_result);
    }

    public function testFindMainContent()
    {
        $result = HtmlHelper::findMainContent(HtmlHelperTest::$html);
        $expected_result = HtmlHelper::getHtmlFrom("samples/main_content.html");

        $this->assertEquals($result, $expected_result);

    }

    public function testFixHtml()
    {
        $result = HtmlHelper::fixHtml(HtmlHelperTest::$html);
        $expected_result = HtmlHelper::getHtmlFrom("samples/fixed_html.html");

        $this->assertEquals($result, $expected_result);

    }

    public function testClearLink()
    {
        $links = [
            "http://www.google.com",
            "https://www.google.com",
            "http://google.com",
            "https://google.com"
        ];

        foreach ($links as $link) {
            echo $link;
            $this->assertEquals("google.com", HtmlHelper::clearLink($link));
        }
    }
}