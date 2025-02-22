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
if (isset($_SESSION["jd_user"]) && $_SESSION["jd_user"]["user_type"] == "head" || $_SESSION["jd_admin"]) {
    

    $pId = $_GET["pid"];

    $message = new stdClass();

    if (empty($pId)) {
        $message->type = "error";
        $message->message = "Invalid Request";
        echo json_encode($message);
    } else {

        $results = Database::operation("SELECT * FROM `pending_attendance` WHERE `id`='" . $pId . "' AND `status`='1'", "s");

        if ($results->num_rows == 1) {
            $userDetails = $results->fetch_assoc();
            Database::operation("INSERT INTO `attendance`(`user_id`,`date_time`,`description`)VALUES('" . $userDetails["user_id"] . "','" . $userDetails["date_time"] . "','" . $userDetails["task"] . "')", "iud");

            Database::operation("UPDATE `pending_attendance` SET `status`='0' WHERE `id`='" . $pId . "' ", "iud");

            $message->type = "success";
            $message->message = "Attendance marked success";
            echo json_encode($message);
        } else {


            $message->type = "error";
            $message->message = "Attendance Approved Faild";
            echo json_encode($message);
        }
    }
}
