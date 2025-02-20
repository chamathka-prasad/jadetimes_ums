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
    $document = $_POST["document"];


    $message = new stdClass();

    if (empty($document)) {
        $message->type = "error";
        $message->message = "Add a Document Type";
        echo json_encode($message);
    } else {


        $userResult = Database::operation("SELECT * FROM `document_type` WHERE `document_type`.`name`='" . $document . "'", "s");
        if ($userResult->num_rows > 0) {
            $message->type = "error";
            $message->message = "Added Document Type Already Exsits ";
            echo json_encode($message);
        } else {

            Database::operation("INSERT INTO `document_type`(`name`)VALUES('" . $document . "')", "iud");
            $message->type = "success";
            $message->message = "Success";
            echo json_encode($message);
        }
    }
}
