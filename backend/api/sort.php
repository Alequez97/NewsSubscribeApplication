<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once("../../databaseImport.php");

if (!isset($_GET["provider"]))
{
    echo json_encode(array("subscribers" => []));
    return;
}

$providers = $_GET["provider"];

try
{
    $query = "SELECT * FROM subscribers WHERE (";
    foreach($providers as $provider)
    {
        $query .= "email LIKE '%@" . $provider . "%' OR ";
    }
    $query = substr($query, 0, -4);  //remove unnecessary "OR"
    $query .= ")";
    if (isset($_GET["email"]))
    {
        $email = $_GET["email"];
        $query .= " AND email LIKE '$email%'";
    }

    if (!empty($_GET["orderby"]) && !empty($_GET["order"]))
    {
        $query .= " ORDER BY " . $_GET["orderby"] . " " . $_GET["order"];
    }
    else
    {
        $query .= " ORDER BY subscription_date DESC";
    }

    $result = $dbWorker->ExecuteQuery($query);
    
    $subscribers = array();
    while ($subscriber = $result->fetch_object())
    {
        $subscribers[] = $subscriber;
    }
    
        http_response_code(200);    
        if (empty($subscribers))
        {
            echo json_encode(array("subscribers" => []));
        }
        else
        {
            echo json_encode(array("subscribers" => $subscribers));
        }
        
}
catch (Exception $e)
{
    http_response_code(500);
}
