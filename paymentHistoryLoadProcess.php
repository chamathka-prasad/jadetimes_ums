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

    $page = $_POST["page"];

    if (empty($page)) {
        $page = 0;
    }

    $typeFilter = "ORDER BY `payment`.`date` DESC";


    if (!empty($searchText)) {
        $typeFilter = "WHERE `user`.`fname` LIKE '" . $searchText . "%'"." ORDER BY `payment`.`date` DESC";
    }

    
    $offset = ($page - 1) * 25;

    $message = new stdClass();

    $userResultCount = Database::operation("SELECT COUNT(*) AS total_rows FROM `user` 
    INNER JOIN `staff` ON `staff`.`user_id`=`user`.`id`
    INNER JOIN `payment` ON `payment`.`staff_id`=`staff`.`id`
     INNER JOIN `position` ON `position`.`id`=`user`.`position_id`
      INNER JOIN `department` ON `department`.`id`=`position`.`department_id` 
      INNER JOIN `user_status` ON `user`.`user_status_id`=`user_status`.`id` 
      INNER JOIN `type` ON `type`.`id`=`user`.`type_id` 
      LEFT JOIN `profile_image` ON `profile_image`.`user_id`=`user`.`id`" . $typeFilter, "s");



    $userResult = Database::operation("SELECT user.fname,user.lname,user.email,payment.date,staff.month_start,payment.description,payment.type,payment.price  FROM `user` INNER JOIN `staff` ON `staff`.`user_id`=`user`.`id` INNER JOIN `payment` ON `payment`.`staff_id`=`staff`.`id` INNER JOIN `position` ON `position`.`id`=`user`.`position_id` INNER JOIN `department` ON `department`.`id`=`position`.`department_id` INNER JOIN `user_status` ON `user`.`user_status_id`=`user_status`.`id` INNER JOIN `type` ON `type`.`id`=`user`.`type_id` LEFT JOIN `profile_image` ON `profile_image`.`user_id`=`user`.`id`" . $typeFilter . " LIMIT 25 OFFSET " . $offset, "s");


    if ($userResult->num_rows != 0) {

        $number = $userResultCount->fetch_assoc();
        $data = [];
        while ($row = $userResult->fetch_assoc()) {
            $data[] = array_values($row);
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
