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

    $admin = $_SESSION["jd_admin"];

    $user = $_POST["user"];
    $date = $_POST["date"];
    $reason = $_POST["reason"];
    $type = $_POST["type"];



    $message = new stdClass();



    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $today = $d->format("Y-m-d");
     $month = $d->format("Y-m");

    if ($user == 0) {
        $message->type = "error";
        $message->message = "Select a user";
        echo json_encode($message);
    } else if (empty($date)) {
        $message->type = "error";
        $message->message = "Add a date";
        echo json_encode($message);
    } else if (empty($reason)) {
        $message->type = "error";
        $message->message = "add a reason";
        echo json_encode($message);
    } else if (empty($type)) {
        $message->type = "error";
        $message->message = "add a type";
        echo json_encode($message);
    } else if (strtotime("+2 days") < strtotime($date)) {
        $message->type = "error";
        $message->message = "Admin can only mark Past Leaves and Emergency Leaves";
        echo json_encode($message);
    } else {


  $userResultC = Database::operation("SELECT * FROM `leave` WHERE `leave`.`user_id`='" . $user . "' AND `leave`.`leave_date` LIKE '" . $month . "%' AND `leave`.`leave_status_id` IN ('1','2','4')", "s");
        if ($userResultC->num_rows >= 3 && $type!=3) {
            $message->type = "error";
            $message->message = "Employee reached the maximun leaves.Cannot request a leave.";
            echo json_encode($message);
        }else{
            
                    $userResult = Database::operation("SELECT * FROM `leave` WHERE `leave`.`user_id`='" . $user . "' AND `leave`.`leave_date` = '" . $date . "'", "s");
        if ($userResult->num_rows > 0) {
            $message->type = "error";
            $message->message = "Already Requested the Leave for " . $date;
            echo json_encode($message);
        } else {

            $leaveStatus = "1";
            if ($type == 1) {
                $leaveStatus = "4";
            }else if($type == 3){
                 $leaveStatus = "5";
            }

            Database::operation("INSERT INTO `leave`(`user_id`,`leave_date`,`reason`,`leave_status_id`)VALUES('" . $user . "','" . $date . "','" . $reason . "','" . $leaveStatus . "')", "iud");
            $message->type = "success";
            $message->message = "Leave Requested Successfully";
            echo json_encode($message);
        }
        
        }


    }
}
