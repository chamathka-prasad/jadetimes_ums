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
if (isset($_SESSION["jd_admin"]) || isset($_SESSION["jd_user"])) {




    $userId = "";
    if (isset($_SESSION["jd_admin"])) {
        $userId = $_SESSION["jd_admin"]["id"];
    } else {
        $userId = $_SESSION["jd_user"]["id"];
        if ($_SESSION["jd_user"]["user_type"] == "director") {           
            return;
        }
    }
    require "connection.php";


    $message = new stdClass();

    $userResultPrevious = Database::operation("SELECT * FROM `feedback` WHERE `user_id`='" . $userId . "'  ORDER BY `datetime` DESC LIMIT 1", "s");

    $sort = "";
    if ($userResultPrevious->num_rows != 0) {
        $prevDetails = $userResultPrevious->fetch_assoc();
        $sort = " WHERE `id`>" . $prevDetails["feedback_message_id"];
    }

    $userResult = Database::operation("SELECT * FROM `feedback_message` $sort  ORDER BY `datetime` ASC LIMIT 1", "s");


    if ($userResult->num_rows != 0) {
        $row = $userResult->fetch_assoc();


        if ($row["months"] == 0) {
            $message->message = $row;
            $message->type = "success";
            echo json_encode($message);
        } else {
            $userIdDetails = Database::operation("SELECT * FROM `user` WHERE `user`.`id`='" . $userId . "'", "s");
            $monthCount = $row["months"];

            $today = new DateTime();
            $today->modify("-$monthCount months");

            $newDate = $today->format('Y-m-d');
            if ($userIdDetails->num_rows > 0) {
                $userRow = $userIdDetails->fetch_assoc();
                $anotherDate = $userRow["reg_date"];


                $newDateTime = new DateTime($newDate);
                $anotherDateTime = new DateTime($anotherDate);
                if ($newDateTime > $anotherDateTime) {
                    $message->message = $row;
                    $message->type = "success";
                    echo json_encode($message);
                }
            }
        }
    }
}
