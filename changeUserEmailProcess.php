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

    $email = $_POST["email"];
    $newemail = $_POST["newemail"];




    $message = new stdClass();


    if (empty($email)) {
        $message->type = "error";
        $message->message = "Old email is empty";
        echo json_encode($message);
    } else if (empty($newemail)) {
        $message->type = "error";
        $message->message = "New email is empty";
        echo json_encode($message);
    } else {

        $resultsUser = Database::operation("SELECT * FROM `user` WHERE `user`.`email`='" . $email . "'", "s");
        if ($resultsUser->num_rows == 1) {

            $checkemail = Database::operation("SELECT * FROM `user` WHERE `user`.`email`='" . $newemail . "'", "s");
            if ($checkemail->num_rows > 0) {
                $message->type = "error";
                $message->message = "New Email is Alredy Registred On the system";
                echo json_encode($message);
            } else {
                Database::operation("UPDATE `user` SET `user`.`email`='" . $newemail . "' WHERE user.email='" . $email . "'", "iud");
                $message->type = "success";
                $message->message = "Email update Success";
                echo json_encode($message);
            }
        } else {
            $message->type = "error";
            $message->message = "invalid user email";
            echo json_encode($message);
        }
    }
}
