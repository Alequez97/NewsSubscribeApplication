<?php

class DatabaseWorkerFactory
{
    public static function GetMySqlDatabaseWorker($host, $username, $password, $databaseName)
    {
        $mysqlDb = new MySqlDatabaseConnection($host, $username, $password, $databaseName);
        $dbWorker = new DatabaseWorker($mysqlDb);
        return $dbWorker;
    }
}

?>