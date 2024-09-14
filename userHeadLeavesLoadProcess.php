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
if (isset($_SESSION["jd_user"]) && $_SESSION["jd_user"]["user_type"] == "head") {

    require "connection.php";

    $selectUser = $_POST["selectUser"];
    $from = $_POST["from"];
    $to = $_POST["to"];
    $order = $_POST["order"];
    $status = $_POST["status"];




    $page = $_POST["page"];

    if (empty($page)) {
        $page = 0;
    }

    $typeFilter = "";


    if (!empty($selectUser)) {
        $typeFilter = "AND `user`.`id`='" . $selectUser . "'";
    }

    if (!empty($from)) {

        if (empty($to)) {
            if (empty($typeFilter)) {
                $typeFilter = "AND `leave`.`leave_date` ='" . $from . "'";
            } else {
                $typeFilter = $typeFilter . " AND `leave`.`leave_date` = '" . $from . "'";
            }
        } else {
            if (empty($typeFilter)) {
                $typeFilter = "AND `leave`.`leave_date` >= '" . $from . "' AND `leave`.`leave_date` <= '" . $to . "'";
            } else {
                $typeFilter = $typeFilter . " AND `leave`.`leave_date` >= '" . $from . "' AND `leave`.`leave_date` <= '" . $to . "'";
            }
        }
    }

    if (!empty($status)) {

        if (empty($typeFilter)) {
            if ($status != 0) {
                $typeFilter = "AND `leave`.`leave_status_id` ='" . $status . "'";
            }
        } else {
            if ($status != 0) {
                $typeFilter = $typeFilter . " AND `leave`.`leave_status_id` ='" . $status . "'";
            }
        }
    }



    if (!empty($order)) {
        if (empty($typeFilter)) {
            if ($order == "DESC") {
                $typeFilter = " ORDER BY `leave`.`leave_date` DESC";
            } else if ($order == "ASC") {
                $typeFilter = " ORDER BY `leave`.`leave_date` ASC";
            } else {
                $typeFilter = $typeFilter . " ORDER BY `leave`.`leave_date` DESC";
            }
        } else {
            if ($order == "DESC") {
                $typeFilter = $typeFilter . " ORDER BY `leave`.`leave_date` DESC";
            } else if ($order == "ASC") {
                $typeFilter = $typeFilter . " ORDER BY `leave`.`leave_date` ASC";
            } else {
                $typeFilter = $typeFilter . " ORDER BY leave.leave_date DESC";
            }
        }
    }



    $offset = ($page - 1) * 25;

    $message = new stdClass();

    $userResultCount = Database::operation("SELECT COUNT(*) AS total_rows FROM `leave`
     INNER JOIN `user` ON `user`.`id`=`leave`.`user_id` " . $typeFilter, "s");



    $userResult = Database::operation("SELECT user.fname,user.lname,user.email,user.jid,leave.leave_date,leave.leave_status_id,leave.id  FROM `leave`
     INNER JOIN `user` ON `user`.`id`=`leave`.`user_id`  INNER JOIN `position` ON `position`.`id`=`user`.`position_id` INNER JOIN `department` ON `department`.`id`=`position`.`department_id` WHERE `department`.`name`='" . $_SESSION["jd_user"]["department"] . "' " . $typeFilter . " LIMIT 25 OFFSET " . $offset, "s");


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
