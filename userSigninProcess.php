<?php
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
$body = file_get_contents('php://input');
$send = json_decode($body);

$email = $send->email;
$password = $send->password;
$rememberPassword = $send->rememberPassword;

$message = new stdClass();
$results = Database::operation("SELECT `user`.`id`,`user`.`email`,`user`.`password`,`user`.`fname`,`user`.`lname`,`user`.`jid`,`type`.`name` AS `user_type`,`position`.`name` AS `position`,`department`.`name` AS `department`,`profile_image`.`name` AS `imgPath`,`department`.`id` AS `department_id` FROM `user` INNER JOIN `type` ON  `type`.`id`=`user`.`type_id` INNER JOIN `user_status` ON `user`.`user_status_id`=`user_status`.`id` INNER JOIN `position` ON `position`.`id`=`user`.`position_id` INNER JOIN `department` ON `department`.`id`=`position`.`department_id` LEFT JOIN  `profile_image` ON `profile_image`.`user_id`=`user`.`id` WHERE `type`.`name` IN ('user','head','contributor','director') AND `user`.`email`='" . $email . "' AND `user`.`password`='" . $password . "' AND `user_status`.`name`='ACTIVE'", "s");

if ($results->num_rows == 1) {
    $userDetails = $results->fetch_assoc();

    session_start();
    $_SESSION["jd_user"] = $userDetails;

    $message->type = "success";
    $message->message = "correct username and password";
    echo json_encode($message);
    if ($rememberPassword == "true") {

        setcookie("email_user", $email, time() + (60 * 60 * 24 * 15));
        setcookie("password_user", $password, time() + (60 * 60 * 24 * 15));
    }
} else {

    $message->type = "error";
    $message->message = "Incorrect username or password";
    echo json_encode($message);
}
