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

    $userEmail = $_POST["userEmail"];
    $price = $_POST["price"];
    $customDesc = $_POST["customDesc"];

    $message = new stdClass();

    if (empty($userEmail)) {
        $message->type = "error";
        $message->message = "invalid Request";
        echo json_encode($message);
    } else if (empty($price)) {
        $message->type = "error";
        $message->message = "Invalid Price";
        echo json_encode($message);
    } else if (empty($customDesc)) {
        $message->type = "error";
        $message->message = "Add a Description";
        echo json_encode($message);
    } else {

        $checkUserAvailableResultSet = Database::operation("SELECT `staff`.`id`,`staff`.`earning` FROM `staff`  INNER JOIN `user` ON `user`.`id`=`staff`.`user_id` WHERE `user`.`email`='" . $userEmail . "'", "s");
        if ($checkUserAvailableResultSet->num_rows == 0) {

            $message->type = "error";
            $message->message = "INVALID REQUEST";
            echo json_encode($message);
        } else {

            $profile = $checkUserAvailableResultSet->fetch_assoc();
            $d = new DateTime();
            $tz = new DateTimeZone("Asia/Colombo");
            $d->setTimezone($tz);
            $dateTimeNow = $d->format("Y-m-d H:i:s");

            Database::operation("INSERT INTO `payment`(`staff_id`,`date`,`description`,`type`,`price`)VALUES('" . $profile["id"] . "','" . $dateTimeNow . "','" . $customDesc . "','0','".$price."')", "iud");

            $currentEarnings = $profile["earning"];
            $newEarning = $currentEarnings + $price;

            Database::operation("UPDATE `staff` SET `earning`='" . $newEarning . "' WHERE `id`='" . $profile["id"] . "'", "iud");

            $message->type = "success";
            $message->message = "Payment Success";
            echo json_encode($message);
        }
    }
}
