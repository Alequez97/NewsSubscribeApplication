<?php

class DatabaseCredentailsReader
{

    private $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    public function ReadDatabaseCredentials()
    {
        $file = fopen($this->filePath, "r") or die("Unable to open file!");

        try
        {
            $host = explode(":", fgets($file))[1];
            $username = explode(":", fgets($file))[1];
            $password = explode(":", fgets($file))[1];
            $dbName = explode(":", fgets($file))[1];
    
            fclose($file);
            return ["host" => $host, "username" => $username, "password" => $password, "database_name" => $dbName];
        }
        catch (Exception $e)
        {
            throw $e;
        }
        
    }
}
