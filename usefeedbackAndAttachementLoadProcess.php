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

    $selectUser = $_POST["selectUser"];

    $status = $_POST["status"];




    $page = $_POST["page"];

    if (empty($page)) {
        $page = 0;
    }

    $typeFilter = "";


    if (!empty($selectUser)) {
        $typeFilter = "WHERE `user`.`id`='" . $selectUser . "'";
    }


    if (!empty($status)) {



        if (empty($typeFilter)) {
            if ($status == 1) {
                $typeFilter = "WHERE `user_feedback`.`status` ='1'";
            } else if ($status == 2) {
                $typeFilter = "WHERE `user_feedback`.`status` ='0'";
            }
        } else {
            if ($status == 1) {
                $typeFilter = $typeFilter . " AND `user_feedback`.`status` ='1'";
            } else if ($status == 2) {
                $typeFilter = $typeFilter . " AND `user_feedback`.`status` ='0'";
            }
        }
    }





    $offset = ($page - 1) * 25;

    $message = new stdClass();




    $userResultCount = Database::operation("SELECT COUNT(*) AS total_rows FROM `user_feedback`
     INNER JOIN `user` ON `user`.`id`=`user_feedback`.`user_id` " . $typeFilter, "s");



    $userResult = Database::operation("SELECT user_feedback.id,user_feedback.feedback,user_feedback.rating,user_feedback.datetime,user_feedback.status,user.fname,user.lname,user.email  FROM `user_feedback`
     INNER JOIN `user` ON `user`.`id`=`user_feedback`.`user_id` " . $typeFilter . " LIMIT 25 OFFSET " . $offset, "s");


    if ($userResult->num_rows != 0) {

        $number = $userResultCount->fetch_assoc();
        $data = [];
        while ($row = $userResult->fetch_assoc()) {
            $data[] = $row;
        }
        $message->message = $data;
        $message->type = "success";
        $rowCount = $number["total_rows"];

        $count = intval($rowCount / 25);
        if ($rowCount % 25 != 0) {
            $count = $count + 1;
        }

        $message->buttoncount = $count;

        echo json_encode($message);
    } else {
        $message->message = "oops !! you got nothing";
        $message->type = "error";
        echo json_encode($message);
    }
} else {
}
