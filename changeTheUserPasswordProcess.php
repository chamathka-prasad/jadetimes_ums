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
    $body = file_get_contents('php://input');

    $adminSession = $_SESSION["jd_user"];
    $send = json_decode($body);
    $oldPass = $send->oldPassword;
    $newPass = $send->newPassword;
    $repertPass = $send->repeatPassword;



    $message = new stdClass();

    if (strlen($oldPass) == 0) {
        $message->type = "error";
        $message->message = "Old password is empty";
    } elseif (strlen($newPass) == 0) {
        $message->type = "error";
        $message->message = "New password is empty";
    } elseif (strlen($newPass) < 8 || strlen($newPass) > 12) {

        $message->type = "error";
        $message->message = "New Password must be larger than 8 and smaller than 12 Characters";
    } elseif (strlen($repertPass) == 0) {

        $message->type = "error";
        $message->message = "Repeat the New Password";
    } elseif ($newPass != $repertPass) {

        $message->type = "error";
        $message->message = "Repeat the Password Correctly";
    } else {

        $userResults = Database::operation("SELECT * FROM `user` WHERE `user`.`id`='" . $adminSession["id"] . "' AND `user`.`password`='" . $oldPass . "' ", "s");
        if ($userResults->num_rows == 1) {

            $user = $userResults->fetch_assoc();
            if ($user["password"] == $newPass) {
                $message->type = "error";
                $message->message = "You are using the old password. Try a different password.";
            } else {

                Database::operation("UPDATE `user` SET `user`.`password`='" . $newPass . "' WHERE `user`.`id`='" . $adminSession["id"] . "'", "iud");
                $message->type = "success";
                $message->message = "Password Updated.";
            }
        } else {
            $message->type = "error";
            $message->message = "Add the OLD Password Correctly";
        }
    }
    echo json_encode($message);
}
