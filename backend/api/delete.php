<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once("../../databaseImport.php");

if (!empty($_GET["id"]))
{
    $id = $_GET["id"];
    try 
    {
        $dbWorker->Delete("subscribers", $id);
        http_response_code(200);
        echo json_encode(array("message" => "Subscriber successfully deleted!"));
    }
    catch (Exception $e)
    {
        http_response_code(500);
    }
}