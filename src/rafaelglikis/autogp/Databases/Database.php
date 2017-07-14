<?php
namespace rafaelglikis\autogp\Databases;
use SQLite3;

class Database extends SQLite3
{
    private $dbName;

    public function __construct($dbName)
    {
        $this->dbName = $dbName;
    }

    public function executeSQL(string $sql)
    {
        $this->open($this->dbName);
        $result = $this->query($sql);
        $this->close();

        return $result;
    }

    /***************************************************************
     *                      ADDERS - GETTERS
     ***************************************************************/

    public function getDbName(): string
    {
        return $this->dbName;
    }

    public function setDbName(string $dbName)
    {
        $this->dbName = $dbName;
    }
}
