<?php
namespace rafaelglikis\autogp\Databases;

class KeyValueDatabase extends Database
{
    private $tableName;
    private $key;
    private $value;

    function __construct($dbName, $tableName = "KEY_VALUE", $key="KEY" , $value="VALUE")
    {
        $this->tableName = $tableName;
        $this->key = $key;
        $this->value = $value;
        parent::__construct($dbName);
    }

    function createTableIfNotExist()
    {
        $sql ="CREATE TABLE IF NOT EXISTS $this->tableName ($this->key INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, $this->value TEXT NOT NULL)";
        $this->executeSQL($sql);
    }

    function insertRecordIfNotExist($value)
    {
        if(!$this->recordExist($value))
        {
            $sql ="INSERT INTO $this->tableName ($this->value) VALUES ('$value')";
            $this->executeSQL($sql);
        }
    }

    function recordExist($value)
    {
        $this->createTableIfNotExist();
        $this->open($this->getDbName());
        $sql ="SELECT COUNT(*) FROM $this->tableName WHERE $this->value='$value'";
        $ret = $this->query($sql);
        $exist = $ret->fetchArray();
        $exist = $exist[0];
        $this->close();

        return $exist>0;
    }

    function insertRecord($value)
    {
        $sql ="INSERT INTO $this->tableName ($this->value) VALUES ('$value')";
        $this->executeSQL($sql);
    }

    /***************************************************************
     *                      ADDERS - GETTERS
     ***************************************************************/

    public function getTableName(): string
    {
        return $this->tableName;
    }

    public function setTableName(string $tableName)
    {
        $this->tableName = $tableName;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function setKey(string $key)
    {
        $this->key = $key;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value)
    {
        $this->value = $value;
    }
}