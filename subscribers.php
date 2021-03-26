<?php

include_once("databaseImport.php");

$subscribers = $dbWorker->ReadAll('subscribers');
usort($subscribers, function($b, $a) {return strcmp($a->subscription_date, $b->subscription_date);});   //sort by date when page is loaded

$providers = getProviders($subscribers);

function getProviders(array $subscribers)
{
    $providers = array();
    foreach ($subscribers as $subscriber) {
        $providerWithDomain = explode("@", $subscriber->email)[1];
        $provider = explode(".", $providerWithDomain)[0];
        if (!in_array($provider, $providers)) array_push($providers, $provider);
    }

    return $providers;
}

?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="scripts/subscribers-scripts.js"></script>

    <title>Subscribers</title>
</head>

<body>
    <div class="container text-center" id="providers-buttons">
        <?php foreach ($providers as $provider) echo "<button class=\"btn btn-info mb-4 mt-4 ml-2 mr-2 provider-button\">" . $provider . "</button>" ?>
    </div>
    <div class="container text-center pb-4" id="search-bar">
        <input type="text" placeholder="Search" class="text-center">
    </div>
    <div class="col-6 text-center center container">
        <table class="table" id="table">
            <thead class="table-dark">
                <tr>
                    <th><input type="checkbox" id="main-checkbox"></th>
                    <th id="email-table-header" class="data-header">email</th>
                    <th id="date-table-header" class="data-header desc">subscription_date &#8679;</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($subscribers as $subscriber) {
                    $dateTime = DateTime::createFromFormat("Y-m-d H:i:s", $subscriber->subscription_date);
                    echo "<tr id=\"subscriber-row-$subscriber->id\">";
                    echo "<td><input type=\"checkbox\" class=\"checkBoxClass\"></td>";
                    echo "<td style=\"display:none;\">" . $subscriber->id . "</td>";
                    echo "<td>" . $subscriber->email . "</td>";
                    echo "<td>" . $dateTime->format("d-m-Y H:i") . "</td>";
                    echo "<td><button class=\"btn btn-danger\" onclick=\"deleteSubscriber($subscriber->id)\">Delete</button></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <button class="btn btn-warning mb-4" id="import-button">Import CSV</button>
    </div>

</body>

</html>