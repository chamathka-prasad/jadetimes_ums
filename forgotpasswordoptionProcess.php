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


$email = $_POST["email"];
$new = $_POST["new"];
$rep = $_POST["rep"];
$reference = $_POST["reference"];

$message = new stdClass();
if (strlen($new) == 0) {
    $message->type = "error";
    $message->message = "New password is empty";
} elseif (strlen($new) < 8 || strlen($new) > 12) {

    $message->type = "error";
    $message->message = "New Password must be larger than 8 and smaller than 12 Characters";
} elseif (strlen($rep) == 0) {

    $message->type = "error";
    $message->message = "Repeat the New Password";
} elseif ($new != $rep) {

    $message->type = "error";
    $message->message = "Repeat the Password Correctly";
} else {

    $userResults = Database::operation("SELECT * FROM `user` WHERE `user`.`email`='" . $email . "' AND `user`.`ref_no`='" . $reference . "' AND `user`.`user_status_id`='1'", "s");
    if ($userResults->num_rows == 1) {

        $code = "JT" . uniqid();

        Database::operation("UPDATE `user` SET `user`.`password`='" . $new . "',`user`.`ref_no`='" . $code . "' WHERE `user`.`email`='" . $email . "'", "iud");
        $message->type = "success";
        $message->message = "Password Changed. Login using changed password";
    } else {
        $message->type = "error";
        $message->message = "Invaild Reference";
    }
}

echo json_encode($message);
