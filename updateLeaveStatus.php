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
if (isset($_SESSION["jd_admin"])) {

    require "connection.php";

    $leaveState = $_POST["leaveState"];
    $uid = $_POST["uid"];


    $message = new stdClass();

    $checkexitingResult = Database::operation("SELECT * FROM `leave` WHERE `leave`.`id`='" . $uid . "'", "s");
    if ($checkexitingResult->num_rows == 1) {
        $leave = $checkexitingResult->fetch_assoc();
        if ($leave["leave_status_id"] == $leaveState) {
            $message->type = "error";
            $message->message = "Change the leave Status";
            echo json_encode($message);
        } else {

            Database::operation("UPDATE `leave` SET `leave_status_id`='" . $leaveState . "' WHERE `leave`.`id`='" . $uid . "'", "iud");
            $message->type = "success";
            $message->message = "Status Updated";
            echo json_encode($message);
        }
    } else {
        $message->type = "error";
        $message->message = "Invalid Request";
        echo json_encode($message);
    }
} else {
}
