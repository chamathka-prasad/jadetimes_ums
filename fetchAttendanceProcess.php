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

    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);

    $today = $d->format("Y-m-d");

    $timeGap = strtotime("-3 month");


    $message = new stdClass();
    $gap = date("Y-m-d h:i:s", $timeGap);

    $results = Database::operation("SELECT * FROM `attendance` WHERE `user_id`='" . $userSession["id"] . "' AND `date_time`>='" . $gap . "'", "s");
    $data = [];
    if ($results->num_rows > 0) {

       
        while ($row = $results->fetch_assoc()) {
            $data[] = array_values($row);
        }
    }

    $resultsLeave = Database::operation("SELECT leave_date,leave_status_id FROM `leave` WHERE `user_id`='" . $userSession["id"] . "' AND `leave_date`>='" . date("Y-m-d", $timeGap) . "' AND `leave_status_id` IN('2','4','5')", "s");

    $leaves = [];
    if ($resultsLeave->num_rows > 0) {


        while ($row = $resultsLeave->fetch_assoc()) {
            $leaves[] = array_values($row);
        }
    }

    $resultPending = Database::operation("SELECT date_time FROM `pending_attendance` WHERE `user_id`='" . $userSession["id"] . "' AND `date_time`>='" . $gap . "' AND `status` ='1'", "s");

    $pedingAttendece = [];
    if ($resultPending->num_rows > 0) {


        while ($row = $resultPending->fetch_assoc()) {
            $pedingAttendece[] = array_values($row);
        }
    }

    $message->type = "info";
    $message->message = $data;
    $message->leave = $leaves;
    $message->pending = $pedingAttendece;
    echo json_encode($message);
}
