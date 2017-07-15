<?php
use PHPUnit\Framework\TestCase;
use rafaelglikis\autogp\Helpers\TextHelper;

class TextHelperTest extends TestCase
{
    private static $str;

    public static function setUpBeforeClass()
    {
        TextHelperTest::$str = "<html><head><title>This is the title</title></head><body><p>Paragraph</p></body></html>";
    }

    public function testStrCut()
    {
        $this->assertEquals(TextHelper::strCut(TextHelperTest::$str), TextHelperTest::$str);
        $this->assertEquals(TextHelper::strCut(TextHelperTest::$str, "<p>"), "Paragraph</p></body></html>");
        $this->assertEquals(TextHelper::strCut(TextHelperTest::$str, "<p>", "</p>"), "Paragraph");
        $this->assertEquals(TextHelper::strCut(TextHelperTest::$str, null, "<head>"), "<html>");
    }

    public function testSimpleDiff()
    {
        $this->assertEquals(TextHelper::simpleDiff("This is a test", "This is a testa"), "testa");
    }
}