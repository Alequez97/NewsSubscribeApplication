<?php

include_once("backend/services/DatabaseCredentialsReader.php");

// include database
include_once("backend/services/DatabaseWorkerFactory.php");
include_once("backend/interfaces/IDatabaseConnection.php");
include_once("backend/database/MySqlDatabaseConnection.php");
include_once("backend/interfaces/IDatabaseWorker.php");
include_once("backend/services/DatabaseWorker.php");

define('PROJECT_ROOT', $_SERVER["DOCUMENT_ROOT"] . "/magebit/");
$filePath = PROJECT_ROOT . "/database_credentials.txt";

$dbCredentialsReader = new DatabaseCredentailsReader($filePath);
$dbCredentials = $dbCredentialsReader->ReadDatabaseCredentials();
$host = trim($dbCredentials["host"]);
$username = trim($dbCredentials["username"]);
$password = trim($dbCredentials["password"]);
$dbName = trim($dbCredentials["database_name"]);

$dbWorker = DatabaseWorkerFactory::GetMySqlDatabaseWorker($host, $username, $password, $dbName);

?>