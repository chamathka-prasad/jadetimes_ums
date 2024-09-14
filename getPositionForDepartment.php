<?php
session_start();
require "connection.php";
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

    $body = file_get_contents('php://input');
    $send = json_decode($body);

    $message = new stdClass();

    $positionResults = Database::operation("SELECT * FROM `position` WHERE `position`.`department_id`='" . $send . "'", "s");
    if ($positionResults->num_rows >= 1) {


        $message->type = "success";

        $data = [];
        while ($row = $positionResults->fetch_assoc()) {
            $data[] = array_values($row);
        }
        $message->type = "success";
        $message->message = $data;
        echo json_encode($message);
    } else {

        $message->type = "error";
        $message->message = "no registered position for department";
        echo json_encode($message);
    }
}
