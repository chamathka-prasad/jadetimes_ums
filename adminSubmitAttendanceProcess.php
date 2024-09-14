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

    $admin = $_SESSION["jd_admin"];

    $user = $_POST["user"];
    $date = $_POST["date"];
    $task = $_POST["task"];
    $message = new stdClass();



    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $today = $d->format("Y-m-d");

    if ($user == 0) {
        $message->type = "error";
        $message->message = "Select a user";
        echo json_encode($message);
    } else if (empty($date)) {
        $message->type = "error";
        $message->message = "Add a date";
        echo json_encode($message);
    } else if (empty($task)) {
        $message->type = "error";
        $message->message = "add a task";
        echo json_encode($message);
    } else if (strtotime((new DateTime($date))->format("Y-m-d")) >= strtotime($today)) {
        $message->type = "error";
        $message->message = "Admin can only mark past attendance";
        echo json_encode($message);
    } else {



        $userResult = Database::operation("SELECT * FROM `attendance` WHERE `attendance`.`user_id`='" . $user . "' AND `attendance`.`date_time` LIKE '" . $date . "%'", "s");
        if ($userResult->num_rows > 0) {
            $message->type = "error";
            $message->message = "Already marked the attendance for " . $date;
            echo json_encode($message);
        } else {

            Database::operation("INSERT INTO `attendance`(`user_id`,`date_time`,`description`)VALUES('" . $user . "','" . $date . "','" . $task . "')", "iud");
            $message->type = "success";
            $message->message = "Attendance Marked Successfully";
            echo json_encode($message);
        }
    }
}
