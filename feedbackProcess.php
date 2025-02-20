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

if (isset($_SESSION["jd_admin"]) || isset($_SESSION["jd_user"])) {


    $fid = $_POST["fid"];
    $feedback = $_POST["feedback"];
    $rating = $_POST["rating"];

    $userId = "";
    if (isset($_SESSION["jd_admin"])) {
        $userId = $_SESSION["jd_admin"]["id"];
    } else {
        $userId = $_SESSION["jd_user"]["id"];
    }


    $message = new stdClass();

    if (empty($fid)) {
        $message->type = "error";
        $message->message = "Invalid Request";
        echo json_encode($message);
    } else if (empty($feedback)) {
        $message->type = "error";
        $message->message = "Feedback is empty";
        echo json_encode($message);
    } else if (empty($rating)) {
        $message->type = "error";
        $message->message = "Rating is Empty";
        echo json_encode($message);
    } else {



        $feedbackMessageResult = Database::operation("SELECT * FROM `user_feedback` WHERE `user_feedback`.`id`='" . $fid . "'", "s");
        if ($feedbackMessageResult->num_rows == 1) {

            $d = new DateTime();
            $tz = new DateTimeZone("Asia/Colombo");
            $d->setTimezone($tz);
            $date = $d->format("Y-m-d H:i:s");

            $attachementResults = Database::operation("SELECT * FROM `attachments` WHERE `user_feedback_id`='" . $fid . "' ", "s");
            if ($attachementResults->num_rows != 0) {
                while ($docs = $attachementResults->fetch_assoc()) {
                    Database::operation("INSERT INTO `document`(`path`,`user_id`,`document_type_id`,`datetime`)VALUES('" . $docs["path"] . "','" . $userId . "','".$docs["document_type_id"]."','".$date."')", "iud");
                }
            }
            Database::operation("UPDATE `user_feedback` SET `feedback`='" . $feedback . "',`rating`='" . $rating . "',`status`='1' WHERE `id`='" . $fid . "'", "iud");

            $message->type = "success";
            $message->message = "Feedback Added success";
            echo json_encode($message);
        }
    }
}
