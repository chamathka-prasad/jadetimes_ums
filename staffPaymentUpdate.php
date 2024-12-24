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

require "connection.php";

if (isset($_SESSION["jd_admin"])) {

    $sessionAdmin = $_SESSION["jd_admin"];

    $sid = $_POST["id"];
    $date = $_POST["date"];

    $message = new stdClass();

    if ($sid == 0) {
        $message->type = "error";
        $message->message = "Select a User";
        echo json_encode($message);
    } else if (empty($date)) {
        $message->type = "error";
        $message->message = "Invalid Payment Month empty";
        echo json_encode($message);
    } else {

        $checkUserAvailableResultSet = Database::operation("SELECT * FROM `payment` INNER JOIN `staff` ON `staff`.`id`=`payment`.`staff_id` INNER JOIN `user` ON `user`.`id`=`staff`.`user_id` WHERE `staff`.`id`='" . $sid . "' AND `payment`.`date_month`='" . $date . "'", "s");
        if ($checkUserAvailableResultSet->num_rows != 0) {

            $message->type = "error";
            $message->message = "You Already Made The Payment";
            echo json_encode($message);
        } else {
            $d = new DateTime();
            $tz = new DateTimeZone("Asia/Colombo");
            $d->setTimezone($tz);
            $dateTimeNow = $d->format("Y-m-d H:i:s");
            Database::operation("INSERT INTO `payment`(`staff_id`,`date_month`,`date`)VALUES('" . $sid . "','" . $date . "','" . $dateTimeNow . "')", "iud");


            $message->type = "success";
            $message->message = "Payment Success";
            echo json_encode($message);
        }
    }
}
