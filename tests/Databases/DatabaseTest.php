<?php
use PHPUnit\Framework\TestCase;
use rafaelglikis\autogp\Databases\KeyValueDatabase;
use rafaelglikis\autogp\Databases\CopierDatabase;
use rafaelglikis\autogp\Databases\TesterDatabase;



class DatabaseTest extends TestCase
{
    public function testKeyValueDatabase()
    {
        $db = new KeyValueDatabase("key_value_test.db");

        $url = "http://www.google.com";
        $db->createTableIfNotExist();
        $this->assertEquals(false, $db->recordExist($url));
        $db->insertRecordValueIfNotExist($url);
        $this->assertEquals(true, $db->recordExist($url));

        $url = "http://www.google.com/asdfdsf/";
        $db->createTableIfNotExist();
        $this->assertEquals(false, $db->recordExist($url));
        $db->insertRecordValue($url);
        $this->assertEquals(true, $db->recordExist($url));

        $db->createTableIfNotExist();
        $this->assertEquals("http://www.google.com", $db->getValueOf(1));
        $db->updateValue(1, "www.google.com");
        $this->assertEquals("www.google.com", $db->getValueOf(1));

        $db->createTableIfNotExist();
        $this->assertEquals(false, $db->checkValue(1, "http://www.google.com"));
        $this->assertEquals(true, $db->checkValue(1, "www.google.com"));
        $this->assertEquals(true, $db->checkValue(2, "http://www.google.com/asdfdsf/"));
    }

    public function testCopierDatabase()
    {
        $db = new CopierDatabase("copier_test");

        $url = "http://www.google.com";
        $db->createTableIfNotExist();
        $this->assertEquals(false, $db->recordExist($url));
        $db->insertRecordValueIfNotExist($url);
        $this->assertEquals(true, $db->recordExist($url));

        $url = "http://www.google.com/asdfdsf/";
        $db->createTableIfNotExist();
        $this->assertEquals(false, $db->recordExist($url));
        $db->insertRecordValue($url);
        $this->assertEquals(true, $db->recordExist($url));
    }

    public function testTesterDatabase()
    {
        $db = new TesterDatabase("tester_test");

        $db->createTableIfNotExist();
        $db->addRecord("tester","test");
        $this->assertEquals("test", $db->getResults("tester"));
        $db->updateRecord("tester","test2");
        $this->assertEquals("test2", $db->getResults("tester"));

        $db->createTableIfNotExist();
        $this->assertEquals(false, $db->checkResults("tester", "test"));
        $this->assertEquals(true, $db->checkResults("tester", "test2"));
    }
}