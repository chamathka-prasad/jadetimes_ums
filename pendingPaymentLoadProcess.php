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



    $userResult = Database::operation("SELECT staff.id,user.fname,user.lname,user.email,user.mobile,user.jid,staff.reg_date,staff.month_start FROM `user` INNER JOIN `staff` ON `staff`.`user_id`=`user`.`id` WHERE `user`.`user_status_id`='1'  AND `staff`.`type`='1' " . $typeFilter . "", "s");

    $array = [];
    if ($userResult->num_rows != 0) {


        while ($row = $userResult->fetch_assoc()) {
            $sid = $row["id"];
            $staffRegdate = $row["reg_date"];

            $colomboTimeZone = new DateTimeZone('Asia/Colombo');
            $date = new DateTime('now', $colomboTimeZone);
            $today = $date->format('Y-m-d');



            $paymentDate = new DateTime($row["month_start"]);
            $paymentDate->modify('+29 day');




            #        // Add one month
            $formatDate = $paymentDate->format('Y-m-d');

            if ($today >= $formatDate) {
                $paymentArray = [];
                $paymentArray["fname"] = $row["fname"];
                $paymentArray["id"] = $sid;
                $paymentArray["lname"] = $row["lname"];
                $paymentArray["email"] = $row["email"];
                $paymentArray["period"] = "from :" . $row["month_start"] . " to :" . $formatDate;
                $newdate = $paymentDate->modify('+1 day');
                $paymentArray["start_month"] = $newdate->format('Y-m-d');;
                $array[] = $paymentArray;
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
