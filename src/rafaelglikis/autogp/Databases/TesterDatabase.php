<?php
namespace rafaelglikis\autogp\Databases;

class TesterDatabase extends KeyValueDatabase
{
    public function __construct($dbName)
    {
        $dbFilename = "sessions/tester/$dbName/databases/tests.db";
        if (!is_dir(dirname($dbFilename)))
        {
            mkdir(dirname($dbFilename), 0755, true);
        }
        parent::__construct($dbFilename, "TESTS", "TESTER", "RESULT");
    }

    public function createTableIfNotExist()
    {
        $sql ="CREATE TABLE IF NOT EXISTS " . $this->getTableName()
            . " (" . $this->getKey() . " TEXT PRIMARY KEY NOT NULL, "
            . $this->getValue() . " TEXT NOT NULL)";

        $this->executeSQL($sql);
    }

    public function checkResults($tester, $results)
    {
        return $this->checkValue($tester, $results);
    }

    public function getResults($tester)
    {
        return $this->getValueOf($tester);
    }

    public function updateRecord($tester, $result)
    {
        $this->updateValue($tester, $result);
    }

    public function addRecord($tester, $result)
    {
        $this->insertRecord($tester, $result);
    }

}
