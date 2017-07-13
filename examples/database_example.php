<?php
namespace examples;

require_once("../vendor/autoload.php");
use rafaelglikis\autogp\Databases\Database;
use rafaelglikis\autogp\Databases\KeyValueDatabase;
use rafaelglikis\autogp\Databases\CopierDatabase;

$database = new CopierDatabase("test");

$database->insertRecordIfNotExist("http://www.googlee.com");
var_dump($database->recordExist("http://www.googlee.cofm"));