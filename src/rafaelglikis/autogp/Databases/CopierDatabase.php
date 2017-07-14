<?php
namespace rafaelglikis\autogp\Databases;

use rafaelglikis\autogp\Helpers\HtmlHelper;

class CopierDatabase extends KeyValueDatabase
{
    public function __construct($dbName)
    {
        $dbFilename = "sessions/copier/$dbName/databases/posts.db";
        if (!is_dir(dirname($dbFilename)))
        {
            mkdir(dirname($dbFilename), 0755, true);
        }
        parent::__construct($dbFilename, "POSTS", "ID", "URL");
    }

    public function insertRecordValueIfNotExist($url)
    {
        $url = HtmlHelper::clearLink($url);
        parent::insertRecordValue($url);
    }

    public function recordExist($url)
    {
        $url = HtmlHelper::clearLink($url);
        return parent::recordExist($url);
    }

    public function insertRecordValue($url)
    {
        $url = HtmlHelper::clearLink($url);
        parent::insertRecordValue($url);
    }
}