<?php
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
if (isset($_SESSION["jd_admin"]) || isset($_SESSION["jd_user"])) {




    $userId = "";
    if (isset($_SESSION["jd_admin"])) {
        $userId = $_SESSION["jd_admin"]["id"];
    } else {
        $userId = $_SESSION["jd_user"]["id"];
        if ($_SESSION["jd_user"]["user_type"] == "director") {
            return;
        }
    }
    require "connection.php";


    $message = new stdClass();


    $userResult = Database::operation("SELECT * FROM `user_feedback` WHERE `status`='0'  ORDER BY `datetime` ASC LIMIT 1", "s");


    if ($userResult->num_rows != 0) {
        $row = $userResult->fetch_assoc();
        $message->message = $row;
        $message->type = "success";
        echo json_encode($message);
    }
}
