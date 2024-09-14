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

    $userDate = $_POST["date"];
    $task = $_POST["task"];
    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $date = $d->format("Y-m-d H:i:s");

    $today = $d->format("Y-m-d");

    $message = new stdClass();

    $task = strip_tags($task);
    $task = htmlspecialchars($task, ENT_QUOTES, 'UTF-8');




    if (strtotime($userDate) != strtotime($today)) {
        $message->type = "error";
        $message->message = "Incorrect date reload the page";
        echo json_encode($message);
    } else {

        $results = Database::operation("SELECT * FROM `attendance` WHERE `user_id`='" . $userSession["id"] . "' AND `date_time` LIKE '" . $userDate . "%' ", "s");

        if ($results->num_rows == 1) {
            $userDetails = $results->fetch_assoc();

            $message->type = "error";
            $message->message = "Already marked for today";
            echo json_encode($message);
        } else {

            Database::operation("INSERT INTO `attendance`(`user_id`,`date_time`,`description`)VALUES('" . $userSession["id"] . "','" . $date . "','" . $task . "')", "iud");


            $message->type = "success";
            $message->message = "Attendance marked success";
            echo json_encode($message);
        }
    }
}
