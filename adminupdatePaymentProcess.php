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

    $userEmail = $_POST["userEmail"];
    $regDate = $_POST["regDate"];
    $salary = $_POST["salary"];
    $payStartMonth = $_POST["payStartMonth"];




    $message = new stdClass();

    if (empty($salary)) {
        $salary = 0;
    }

    $results = Database::operation("SELECT * FROM `user` WHERE `email`='" . $userEmail . "'", "s");

    if ($results->num_rows == 1) {

        $userResult=$results->fetch_assoc();
        Database::operation("UPDATE `staff` SET `reg_date`='".$regDate."',`salary`='".$salary."',`month_start`='".$payStartMonth."' WHERE `user_id`='".$userResult["id"]."'", "iud");

        $message->type = "success";
        $message->message = "Payments Setting Update Success";
        echo json_encode($message);
    } else {

        $message->type = "error";
        $message->message = "Invalid Request";
        echo json_encode($message);
    }
}
