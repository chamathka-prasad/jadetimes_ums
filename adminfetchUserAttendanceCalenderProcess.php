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

    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);



    $userId = $_GET["id"];
    $today = $d->format("Y-m-d");

    $timeGap = strtotime("-3 month");


    $message = new stdClass();
    $gap = date("Y-m-d h:i:s", $timeGap);

    $results = Database::operation("SELECT * FROM `attendance` WHERE `user_id`='" . $userId . "'", "s");

    if ($results->num_rows > 0) {

        $data = [];
        while ($row = $results->fetch_assoc()) {
            $data[] = array_values($row);
        }
        $resultsLeave = Database::operation("SELECT leave_date,leave_status_id,id,reason FROM `leave` WHERE `user_id`='" . $userId . "'  AND `leave_status_id` IN('2','4','5')", "s");

        $leaves = [];
        if ($resultsLeave->num_rows > 0) {


            while ($row = $resultsLeave->fetch_assoc()) {
                $leaves[] = array_values($row);
            }
        }
        $message->type = "info";
        $message->message = $data;
        $message->leave = $leaves;

        echo json_encode($message);
    } else {
        $message->type = "info";
        $message->message = "";
        echo json_encode($message);
    }
}
