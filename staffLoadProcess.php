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
    $searchemail = $_POST["searchemail"];
    $searchid = $_POST["searchid"];
    $searchposition = $_POST["searchposition"];
    $searchtype = $_POST["searchtype"];
    $searchstatus = $_POST["searchstatus"];
    $department = $_POST["department"];
    $page = $_POST["page"];

    if (empty($page)) {
        $page = 0;
    }

    $typeFilter = "";


    if (!empty($searchText)) {
        $typeFilter = "WHERE `user`.`fname` LIKE '" . $searchText . "%'";
    }

    if (!empty($searchemail)) {
        if (empty($typeFilter)) {
            $typeFilter = "WHERE `user`.`email` LIKE '" . $searchemail . "%'";
        } else {
            $typeFilter = $typeFilter . " AND `user`.`email` LIKE '" . $searchemail . "%'";
        }
    }

    if (!empty($searchid)) {
        if (empty($typeFilter)) {
            $typeFilter = "WHERE `user`.`jid` LIKE '" . $searchid . "%' ";
        } else {
            $typeFilter = $typeFilter . " AND `user`.`jid` LIKE '" . $searchid . "%' ";
        }
    }

    if (!empty($searchposition)) {
        if (empty($typeFilter)) {
            $typeFilter = "WHERE `position`.`name` LIKE '" . $searchposition . "%' ";
        } else {
            $typeFilter = $typeFilter . " AND `position`.`name` LIKE '" . $searchposition . "%' ";
        }
    }


    if ($searchtype != 0) {
        if (empty($typeFilter)) {
            $typeFilter = "WHERE `user`.`type_id`='" . $searchtype . "'";
        } else {
            $typeFilter = $typeFilter . " AND `user`.`type_id`='" . $searchtype . "'";
        }
    }

    if ($searchstatus != 0) {
        if (empty($typeFilter)) {
            $typeFilter = "WHERE `user`.`user_status_id`='" . $searchstatus . "'";
        } else {
            $typeFilter = $typeFilter . "AND `user`.`user_status_id`='" . $searchstatus . "'";
        }
    }

    if ($department != 0) {
        if (empty($typeFilter)) {
            $typeFilter =  "WHERE `department`.`id`='" . $department . "'";
        } else {
            $typeFilter = $typeFilter . "AND `department`.`id`='" . $department . "'";
        }
    }
    $offset = ($page - 1) * 25;

    $message = new stdClass();

    $userResultCount = Database::operation("SELECT COUNT(*) AS total_rows FROM `user` 
    INNER JOIN `staff` ON `staff`.`user_id`=`user`.`id`
     INNER JOIN `position` ON `position`.`id`=`user`.`position_id`
      INNER JOIN `department` ON `department`.`id`=`position`.`department_id` 
      INNER JOIN `user_status` ON `user`.`user_status_id`=`user_status`.`id` 
      INNER JOIN `type` ON `type`.`id`=`user`.`type_id` 
      LEFT JOIN `profile_image` ON `profile_image`.`user_id`=`user`.`id`" . $typeFilter, "s");



    $userResult = Database::operation("SELECT user.fname,user.lname,user.email,user.mobile,user.jid,user.reg_date,position.name AS position_name,department.name AS department_name,user_status.name AS status_name,profile_image.name AS imagePath,type.name AS user_type,user.duration,staff.reg_date AS staffdate  FROM `user` INNER JOIN `staff` ON `staff`.`user_id`=`user`.`id` INNER JOIN `position` ON `position`.`id`=`user`.`position_id` INNER JOIN `department` ON `department`.`id`=`position`.`department_id` INNER JOIN `user_status` ON `user`.`user_status_id`=`user_status`.`id` INNER JOIN `type` ON `type`.`id`=`user`.`type_id` LEFT JOIN `profile_image` ON `profile_image`.`user_id`=`user`.`id`" . $typeFilter . " LIMIT 25 OFFSET " . $offset, "s");


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
