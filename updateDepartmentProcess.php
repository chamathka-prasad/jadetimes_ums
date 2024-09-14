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
    $department = $_POST["department"];
    $id = $_POST["id"];

    $message = new stdClass();

    if (empty($department)) {
        $message->type = "error";
        $message->message = "department is empty";
        echo json_encode($message);
    } else {


        $userResult = Database::operation("SELECT * FROM `department` WHERE `department`.`name`='" . $department . "'", "s");
        if ($userResult->num_rows > 0) {
            $message->type = "error";
            $message->message = "Department Already Registred";
            echo json_encode($message);
        } else {

            Database::operation("UPDATE `department` SET `department`.`name`='" . $department . "' WHERE `department`.`id`='" . $id . "'", "iud");
            $message->type = "success";
            $message->message = "Success";
            echo json_encode($message);
        }
    }
}
