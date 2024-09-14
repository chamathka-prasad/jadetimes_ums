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

    $order = $_POST["order"];

    $page = $_POST["page"];

    if (empty($page)) {
        $page = 0;
    }


    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);

    $today = $d->format("Y-m-d");

    $typeFilter = " WHERE `user_status_id`='1' AND `user`.`type_id` IN('1','2') AND `attendance`.`date_time`  LIKE '" . $today . "%'";


    if (!empty($selectUser)) {
        if ($selectUser != 0) {
            $typeFilter = $typeFilter . " AND `user`.`id`='" . $selectUser . "'";
        }
    }



    if (!empty($order)) {

        if ($order == "DESC") {
            $typeFilter = $typeFilter . " ORDER BY `attendance`.`date_time` DESC";
        } else if ($order == "ASC") {
            $typeFilter = $typeFilter . " ORDER BY `attendance`.`date_time` ASC";
        } else {
            $typeFilter = $typeFilter . " ORDER BY `attendance`.`date_time` DESC";
        }
    }


    $offset = ($page - 1) * 25;

    $message = new stdClass();


    $userResultCount = Database::operation("SELECT COUNT(*) AS total_rows FROM `attendance`
     INNER JOIN `user` ON `user`.`id`=`attendance`.`user_id` " . $typeFilter, "s");



    $userResult = Database::operation("SELECT user.id,user.fname,user.lname,user.email,user.mobile,user.jid,user.reg_date,attendance.date_time,attendance.description  FROM `user` 
    INNER JOIN  `attendance`  ON `user`.`id`=`attendance`.`user_id` " . $typeFilter . "", "s");





    if ($userResult->num_rows != 0) {

        $attandance_markedByID = [];

      
        $data = [];
        while ($row = $userResult->fetch_assoc()) {
            $attandance_markedByID[] = $row["id"];

            $data[] = array_values($row);
        }


        if ($selectUser == 0) {
            $allUserResult = Database::operation("SELECT user.id,user.fname,user.lname,user.email,user.mobile,user.jid,user.reg_date FROM `user` WHERE `user_status_id`='1' AND `user`.`type_id`!='3' ", "s");

            if ($allUserResult->num_rows != 0) {
                while ($all = $allUserResult->fetch_assoc()) {
                    $status = in_array($all["id"], $attandance_markedByID) ? 1 : 0;
                    if ($status == 0) {
                        $data[] = array_values($all);
                    }
                }
            }
        }





        $message->message = $data;
        $message->type = "success";


        $message->buttoncount = 1;

        echo json_encode($message);
    } else {

        if (!empty($selectUser)) {
            if ($selectUser != 0) {
                $allUserResult = Database::operation("SELECT user.id,user.fname,user.lname,user.email,user.mobile,user.jid,user.reg_date FROM `user` WHERE `user_status_id`='1' AND `user`.`type_id`!='3' AND `user`.`id`='".$selectUser."' ", "s");
                $data = [];
                if ($allUserResult->num_rows != 0) {
                    while ($all = $allUserResult->fetch_assoc()) {

                        $data[] = array_values($all);
                    }
                    $message->message = $data;
                    $message->type = "success";
                    echo json_encode($message);
                } else {
                    $message->message = "oops !! you got nothing";
                    $message->type = "error";
                    echo json_encode($message);
                }
            } else {
                $message->message = "oops !! you got nothing";
                $message->type = "error";
                echo json_encode($message);
            }
        }
    }
} else {
}
