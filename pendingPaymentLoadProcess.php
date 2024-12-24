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

    $searchText = $_POST["searchText"];

    $typeFilter = "";

    if (!empty($searchText)) {
        $typeFilter = "AND `user`.`fname` LIKE '" . $searchText . "%'";
    }


    $message = new stdClass();


   
    $userResult = Database::operation("SELECT staff.id,user.fname,user.lname,user.email,user.mobile,user.jid,staff.reg_date FROM `user` INNER JOIN `staff` ON `staff`.`user_id`=`user`.`id` WHERE `user`.`user_status_id`='1' " . $typeFilter . "", "s");

    $array = [];
    if ($userResult->num_rows != 0) {


        while ($row = $userResult->fetch_assoc()) {
            $sid = $row["id"];
            $staffRegdate = $row["reg_date"];
            $paymentResult = Database::operation("SELECT * FROM `payment` WHERE `payment`.`staff_id`='" . $sid . "' ORDER BY `date` DESC LIMIT 1", "s");

            $colomboTimeZone = new DateTimeZone('Asia/Colombo');
            $date = new DateTime('now', $colomboTimeZone);
            $today = $date->format('Y-m-d');


            if ($paymentResult->num_rows != 0) {
                $paymentData = $paymentResult->fetch_assoc();
                $paymentDate = new DateTime($paymentData["date_month"]);
                $paymentDate->modify('+1 month');        // Add one month
                $paymentDate->format('Y-m-d');
                if ($today >= $paymentDate) {
                    $paymentArray = [];
                    $paymentArray["fname"] = $row["fname"];
                    $paymentArray["id"] = $sid;
                    $paymentArray["lname"] = $row["lname"];
                    $paymentArray["email"] = $row["email"];
                    $paymentArray["date"] = $paymentDate;
                    $array[] = $paymentArray;
                }
            } else {
                $paymentDate = new DateTime($staffRegdate);
                $paymentPlusMonth=$paymentDate->modify('+1 month');        // Add one month
               
                if ($today >= $paymentDate->format('Y-m-d')) {
                    $paymentArray = [];
                    $paymentArray["fname"] = $row["fname"];
                    $paymentArray["id"] = $sid;
                    $paymentArray["lname"] = $row["lname"];
                    $paymentArray["email"] = $row["email"];
                    $paymentArray["date"] = $paymentDate->format('Y-m-d');
                    $array[] = $paymentArray;
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
