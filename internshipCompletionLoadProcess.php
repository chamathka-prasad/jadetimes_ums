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

    $message = new stdClass();



    $userResult = Database::operation("SELECT `user`.id,`user`.`fname`,`user`.`lname`,`user`.`id`,`user`.`prev_attendance`,`user`.`months`,`profile_image`.`name`,`user`.`internship_complete` FROM `user` LEFT JOIN `profile_image` ON `user`.`id`=`profile_image`.`user_id` WHERE `user`.`user_status_id`='1'", "s");

    $array = [];
    if ($userResult->num_rows != 0) {



        while ($row = $userResult->fetch_assoc()) {



            $userResultCount = Database::operation("SELECT COUNT(*) AS total_rows FROM `attendance` WHERE `attendance`.`user_id`='" . $row["id"] . "'", "s");
            if ($userResultCount->num_rows == 1) {


                $count = $userResultCount->fetch_assoc();

                $prev = 0;


                if (!empty($row["prev_attendance"])) {
                    $prev = $row["prev_attendance"];
                }


                $countDays = ($count["total_rows"] + $prev);

                if (empty($row["months"]) || $row["months"] == 0) {
                } else if ($row["internship_complete"] == 1) {
                } else {

                    $completeMonthsDayCount = $row["months"] * 30;


                    if (($countDays + 10) >= $completeMonthsDayCount) {

                        $resultStd = new stdClass();
                        $resultStd->fname = $row["fname"];
                        $resultStd->lname = $row["lname"];
                        $resultStd->path = $row["name"];
                        $resultStd->months = $row["months"];
                        $resultStd->id = $row["id"];
                        $resultStd->count = $completeMonthsDayCount - $countDays;


                        $array[] = $resultStd;
                    }
                }
            }
        }

        $message->message = $array;
        $message->type = "success";
        echo json_encode($message);
    } else {
        $message->message = "oops !! you got nothing";
        $message->type = "error";
        echo json_encode($message);
    }
} else {
}
