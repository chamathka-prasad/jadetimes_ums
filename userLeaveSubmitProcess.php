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
if (isset($_SESSION["jd_user"])) {

    require "connection.php";

    $user = $_SESSION["jd_user"];

    $reason = $_POST["reason"];
    $date = $_POST["date"];

    $message = new stdClass();

    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);

    $today = $d->format("Y-m-d");

    $userDate = new DateTime($date);
    $month = $userDate->format("Y-m");
    $leaveDate = $userDate->format("Y-m-d");

    $date1 = date_create($today);
    $date2 = date_create($leaveDate);
    $diff = date_diff($date1, $date2);



    $gapOfDays = $diff->format("%a");

    $f = (int)$gapOfDays;



    if (empty($date)) {
        $message->type = "error";
        $message->message = "Add a date";
        echo json_encode($message);
    } else if ($date1 >= $date2) {

        $message->type = "error";
        $message->message = "Submit your leave request at least two days before. or use the emergency leave";
        echo json_encode($message);
    } else if ($f < 3) {
        $message->type = "error";
        $message->message = "Submit your leave request at least two days before. or use the emergency leave";
        echo json_encode($message);
    } else if (empty($reason)) {
        $message->type = "error";
        $message->message = "add a Reason";
        echo json_encode($message);
    } else {



        $userResult = Database::operation("SELECT * FROM `leave` WHERE `leave`.`user_id`='" . $user["id"] . "' AND `leave`.`leave_date` LIKE '" . $month . "%' AND `leave`.`leave_status_id` IN ('1','2','4')", "s");
        if ($userResult->num_rows >= 3) {
            $message->type = "error";
            $message->message = "You reached the maximun leaves.You cannot request a leave.";
            echo json_encode($message);
        } else {

            $dateSearchResult = Database::operation("SELECT * FROM `leave` WHERE `leave`.`user_id`='" . $user["id"] . "' AND `leave`.`leave_date`='" . $leaveDate . "'", "s");

            if ($dateSearchResult->num_rows > 0) {
                $message->type = "error";
                $message->message = "Already Request to the added date.";
                echo json_encode($message);
            } else {
                Database::operation("INSERT INTO `leave`(`user_id`,`leave_date`,`reason`,`leave_status_id`)VALUES('" . $user["id"] . "','" . $date . "','" . $reason . "','1')", "iud");
                $message->type = "success";
                $message->message = "Leave Requested Successfully";
                echo json_encode($message);
            }
        }
    }
}
