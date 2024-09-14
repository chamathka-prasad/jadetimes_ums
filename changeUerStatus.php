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
if (isset($_SESSION["jd_admin"])) {
    $userSession = $_SESSION["jd_admin"];

    $status = $_POST["status"];
    $email = $_POST["email"];


    $message = new stdClass();

    $results = Database::operation("SELECT * FROM `user` WHERE `user`.`email`='" . $email . "'", "s");

    if ($results->num_rows == 1) {

        $statusChangeId = 2;
        if ($status == "true") {
            $statusChangeId = 1;
        } else if ($status == "false") {
            $statusChangeId = 2;
        }

        Database::operation("UPDATE `user` SET `user_status_id`='" . $statusChangeId . "' WHERE `user`.`email`='" . $email . "'", "iud");

        $message->type = "success";
        $message->message = "Status Change Success";
        echo json_encode($message);
    } else {



        $message->type = "error";
        $message->message = "Already marked for today";
        echo json_encode($message);
    }
}
