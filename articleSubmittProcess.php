<?php
require "connection.php";
session_start();


// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Handle CORS preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
    header("Access-Control-Max-Age: 86400"); // Cache for 1 day
    exit(0);
}

// Set CORS headers for actual request
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

// Ensure the response is JSON
header("Content-Type: application/json");
if (isset($_SESSION["jd_user"])) {
    $userSession = $_SESSION["jd_user"];

    $artidate = $_POST["date"];
    $title = $_POST["title"];
    $articleType = $_POST["articleType"];


    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $date = $d->format("Y-m-d H:i:s");

    $message = new stdClass();


    $results = Database::operation("SELECT * FROM `user` WHERE `id`='" . $userSession["id"] . "'", "s");

    if ($results->num_rows == 1) {
        Database::operation("INSERT INTO `article`(`title`,`date`,`submit_date`,`user_id`,`type`)VALUES('" . $title . "','" . $artidate . "','" . $date . "','" . $userSession["id"] . "','". $articleType."')", "iud");

        $message->type = "success";
        $message->message = "Article Submit success";
        echo json_encode($message);
    } else {

        $message->type = "error";
        $message->message = "Invalid Request";
        echo json_encode($message);
    }
}
