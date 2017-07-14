<?php
namespace rafaelglikis\autogp\Databases;

class KeyValueDatabase extends Database
{
    private $tableName;
    private $key;
    private $value;

    public function __construct($dbName, $tableName = "KEY_VALUE", $key="KEY" , $value="VALUE")
    {
        $this->tableName = $tableName;
        $this->key = $key;
        $this->value = $value;
        parent::__construct($dbName);
    }

    public function createTableIfNotExist()
    {
        $sql ="CREATE TABLE IF NOT EXISTS $this->tableName ($this->key INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, $this->value TEXT NOT NULL)";
        $this->executeSQL($sql);
    }

    public function insertRecordValueIfNotExist($value)
    {
        if(!$this->recordExist($value))
        {
            $sql ="INSERT INTO $this->tableName ($this->value) VALUES ('$value')";
            $this->executeSQL($sql);
        }
    }

    public function recordExist($value)
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

    public function insertRecordValue($value)
    {
        $sql ="INSERT INTO $this->tableName ($this->value) VALUES ('$value')";
        $this->executeSQL($sql);
    }

    public function insertRecord($key, $value)
    {
        $key=self::escapeString($key);
        $value=self::escapeString($value);
        $sql ="INSERT INTO $this->tableName ($this->key, $this->value) VALUES ('$key', '$value')";
        $this->executeSQL($sql);
    }

    public function checkValue($key, $value)
    {
        $key = self::escapeString($key);
        $this->createTableIfNotExist();
        $this->open($this->getDbName());
        $sql ="SELECT $this->value FROM $this->tableName WHERE $this->key='$key'";
        $ret = $this->query($sql);
        $result = $ret->fetchArray();
        $result = $result[0];
        $this->close();

        return ($result === $value);
    }

    public function getValueOf($key)
    {
        $tester=self::escapeString($key);
        $this->createTableIfNotExist();
        $this->open($this->getDbName());
        $sql ="SELECT $this->value FROM $this->tableName WHERE $this->key='" . "$tester'";
        $ret = $this->query($sql);
        $result = $ret->fetchArray();
        $result = $result[0];
        $this->close();

        return $result;
    }

    public function updateValue($key, $value)
    {
        $key=self::escapeString($key);
        $value=self::escapeString($value);

        $this->createTableIfNotExist();

        $sql ="INSERT OR IGNORE INTO $this->tableName "
            . "($this->key, $this->value) "
            . "VALUES ('$key', '$value')";
        $this->executeSQL($sql);

        $sql ="UPDATE $this->tableName "
            . "SET $this->value ='$value' "
            ."WHERE $this->key='$key'";
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