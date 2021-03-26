<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once("../../databaseImport.php");

$email = isset($_GET['email']) ? $_GET['email'] : die();

if (!validateEmail($email))
{
    return;
}

$query = "SELECT * FROM `subscribers` WHERE email='$email'";
$subscribers = $dbWorker->ExecuteQuery($query)->fetch_object();

if (!empty($subscribers)) {
    http_response_code(400);
    echo json_encode(array("message" => "User with this email already subscribed"));
} else {
    try {
        $date = date('y-m-d h:i:s');
        $result = $dbWorker->Create("subscribers", ["email" => $email, "subscription_date" => $date]);
        http_response_code(200);
        echo json_encode(array("message" => "Subscriber succesfully added"));
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(array("message" => "Unable to subsribe at this time. Try again later"));
    }
}

function validateEmail($email)
{
    if (empty($email))
    {
        http_response_code(400);
        echo json_encode(array("message" => "Error. Email is empty"));
        return false;
    } 

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
    {
        http_response_code(400);
        echo json_encode(array("message" => "Error. Invalid email format"));
        return false;
    }

    $array = explode(".", $email);
    $domain = $array[count($array) - 1];

    if ($domain === "co")
    {
        http_response_code(400);
        echo json_encode(array("message" => "Error. Can't save emails with Columbian domain"));
        return false;
    }

    return true;
}
