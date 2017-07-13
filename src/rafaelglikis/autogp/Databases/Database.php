<?php
namespace rafaelglikis\autogp\Databases;
use SQLite3;

class Database extends SQLite3
{
    private $dbName;

    function __construct($dbName)
    {
        $this->dbName = $dbName;
    }

    function executeSQL(string $sql)
    {
        $this->open($this->dbName);
        $this->query($sql);
        $this->close();
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
