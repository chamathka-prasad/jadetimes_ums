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

    $months = $_POST["months"];
    $feedback = $_POST["feedback"];

    $message = new stdClass();

    if ($months < 0) {
        $message->type = "error";
        $message->message = "Empty Months";
        echo json_encode($message);
    } else if (empty($feedback)) {
        $message->type = "error";
        $message->message = "Empty Feedback";
        echo json_encode($message);
    } else {

        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $date = $d->format("Y-m-d H:i:s");

        Database::operation("INSERT INTO `feedback_message`(`message`,`months`,`datetime`)VALUES('" . $feedback . "','" . $months . "','".$date."')", "iud");
        $message->type = "success";
        $message->message = "New Feedback Section Added Success";
        echo json_encode($message);
    }
}
