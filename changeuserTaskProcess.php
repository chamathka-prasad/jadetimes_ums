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

    $adminSession = $_SESSION["jd_admin"];

    $userTask = $_POST["userTask"];
    $email = $_POST["email"];



    $message = new stdClass();

    if (empty($userTask)) {

        $message->type = "error";
        $message->message = "Task is empty";
    } else {

        $userResults = Database::operation("SELECT * FROM `user` WHERE `user`.`email`='" . $email . "'", "s");
        if ($userResults->num_rows == 1) {

            $user = $userResults->fetch_assoc();
            $taskList = Database::operation("SELECT * FROM `task` WHERE `task`.`user_id`='" . $user["id"] . "'", "s");

            if ($taskList->num_rows == 1) {
                $searchTask = $taskList->fetch_assoc();
                Database::operation("UPDATE `task` SET `task`.`user_task`='" . $userTask . "' WHERE `task`.`id`='" . $searchTask["id"] . "'", "iud");
                $message->type = "success";
                $message->message = "Task Updated Success";
            } else {
                Database::operation("INSERT INTO `task`(`user_task`,`user_id`) VALUES('" . $userTask . "','" . $user["id"] . "')", "iud");
                $message->type = "success";
                $message->message = "Task Added Success";
            }
        } else {
            $message->type = "error";
            $message->message = "Invalid user";
        }
    }
    echo json_encode($message);
}
