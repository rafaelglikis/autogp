<?php
namespace rafaelglikis\autogp\Databases;

use rafaelglikis\autogp\Helpers\HtmlHelper;

class CopierDatabase extends KeyValueDatabase
{
    function __construct($dbName)
    {
        $dbFilename = "sessions/copier/$dbName/databases/posts.db";
        if (!is_dir(dirname($dbFilename)))
        {
            mkdir(dirname($dbFilename), 0755, true);
        }
        parent::__construct($dbFilename, "POSTS", "ID", "URL");
    }

    function insertRecordIfNotExist($url)
    {
        $url = HtmlHelper::clearLink($url);
        parent::insertRecord($url);
    }

    function recordExist($url)
    {
        $url = HtmlHelper::clearLink($url);
        return parent::recordExist($url);
    }

    function insertRecord($url)
    {
        $url = HtmlHelper::clearLink($url);
        parent::insertRecord($url);
    }
}