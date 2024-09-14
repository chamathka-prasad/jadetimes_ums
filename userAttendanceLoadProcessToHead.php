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
    $mark = $_POST["mark"];
    $order = $_POST["order"];


    $page = $_POST["page"];

    if (empty($page)) {
        $page = 0;
    }

    $typeFilter = "";


    if ($selectUser != 0) {
        $typeFilter = "AND `user`.`id`='" . $selectUser . "'";
    }

    if (!empty($from)) {

        if (empty($to)) {
            if (empty($typeFilter)) {
                $typeFilter = "AND `attendance`.`date_time` LIKE '" . $from . "%'";
            } else {
                $typeFilter = $typeFilter . " AND `attendance`.`date_time` LIKE '" . $from . "%'";
            }
        } else {
            if (empty($typeFilter)) {
                $typeFilter = "AND `attendance`.`date_time` >= '" . $from . "' AND `attendance`.`date_time` <= '" . $to . "'";
            } else {
                $typeFilter = $typeFilter . " AND `attendance`.`date_time` >= '" . $from . "' AND `attendance`.`date_time` <= '" . $to . "'";
            }
        }
    }



    if (!empty($order)) {
        if (empty($typeFilter)) {
            if ($order == "DESC") {
                $typeFilter = " ORDER BY `attendance`.`date_time` DESC";
            } else if ($order == "ASC") {
                $typeFilter = " ORDER BY `attendance`.`date_time` ASC";
            } else {
                $typeFilter = $typeFilter . " ORDER BY `attendance`.`date_time` DESC";
            }
        } else {
            if ($order == "DESC") {
                $typeFilter = $typeFilter . " ORDER BY `attendance`.`date_time` DESC";
            } else if ($order == "ASC") {
                $typeFilter = $typeFilter . " ORDER BY `attendance`.`date_time` ASC";
            } else {
                $typeFilter = $typeFilter . " ORDER BY attendance.date_time DESC";
            }
        }
    }




    $offset = ($page - 1) * 25;

    $message = new stdClass();


    if ($mark != 2) {


        $userIdSort = "";
        if ($selectUser != 0) {
            $userIdSort = "AND `user`.`id`='" . $selectUser . "'";
        }

        $userResultSearch = Database::operation("SELECT user.fname,user.lname,user.email,user.mobile,user.jid,user.reg_date,user.id FROM `user` INNER JOIN `position` ON `position`.`id`=`user`.`position_id` INNER JOIN `department` ON `department`.`id`=`position`.`department_id` WHERE `department`.`name`='" . $_SESSION["jd_user"]["department"] . "' AND `user`.`user_status_id`='1' AND `user`.`type_id`!='3' " . $userIdSort . "
        LIMIT 25 OFFSET " . $offset, "s");

        $userResultSearchCount = Database::operation("SELECT COUNT(*) AS total_rows FROM `user` INNER JOIN `position` ON `position`.`id`=`user`.`position_id` INNER JOIN `department` ON `department`.`id`=`position`.`department_id` WHERE `department`.`name`='" . $_SESSION["jd_user"]["department"] . "' AND `user`.`user_status_id`='1' AND `user`.`type_id`!='3' " . $userIdSort . "", "s");
        $userResultsForCheckAttendance = [];





        if ($userResultSearch->num_rows != 0) {


            $attandance_markedByID = [];

            $userIdsFromSearch = array();

            while ($rowSearch = $userResultSearch->fetch_assoc()) {

                $userIdsFromSearch[] = $rowSearch["id"];
                $userResultsForCheckAttendance[] = $rowSearch;
            }


            $ids_string = "'" . implode("','", $userIdsFromSearch) . "'";

            $userResult = Database::operation("SELECT user.fname,user.lname,user.email,user.mobile,user.jid,user.reg_date,attendance.date_time,attendance.description,attendance.id,user.id AS `uid` FROM `user` 
       INNER JOIN  `attendance`  ON `user`.`id`=`attendance`.`user_id` WHERE user.id IN($ids_string) AND `attendance`.`date_time` LIKE '" . $from . "%'", "s");


            $userResultCount = Database::operation("SELECT COUNT(*) AS total_rows FROM `user` 
INNER JOIN  `attendance`  ON `user`.`id`=`attendance`.`user_id` INNER JOIN `position` ON `position`.`id`=`user`.`position_id` INNER JOIN `department` ON `department`.`id`=`position`.`department_id` WHERE `department`.`name`='" . $_SESSION["jd_user"]["department"] . "' AND `attendance`.`date_time` LIKE '" . $from . "%' " . $userIdSort . "", "s");



            $data = [];
            while ($row = $userResult->fetch_assoc()) {
                $attandance_markedByID[] = $row["uid"];

                $data[] = array_values($row);
            }



            if (sizeof($userResultsForCheckAttendance) != 0) {



                for ($check = 0; $check < sizeof($userResultsForCheckAttendance); $check++) {
                    $all = $userResultsForCheckAttendance[$check];
                    $status = in_array($all["id"], $attandance_markedByID) ? 1 : 0;
                    if ($status == 0) {
                        $data[] = array_values($all);
                    }
                }
            }

            $message->message = $data;
            $message->type = "success";
            $number = $userResultSearchCount->fetch_assoc();
            $numberAvailable = $userResultCount->fetch_assoc();

            $availableRow = $numberAvailable["total_rows"];
            $rowCount = $number["total_rows"];

            $count = intval($rowCount / 25);
            if ($rowCount % 25 != 0) {
                $count = $count + 1;
            }

            $message->buttoncount = $count;
            $message->total = $rowCount;
            $message->marked = $availableRow;

            echo json_encode($message);
        }
    } else {
        $userResultCount = Database::operation("SELECT COUNT(*) AS total_rows FROM `attendance` INNER JOIN `user` ON `user`.`id`=`attendance`.`user_id` INNER JOIN `position` ON `position`.`id`=`user`.`position_id` INNER JOIN `department` ON `department`.`id`=`position`.`department_id` WHERE `department`.`name`='" . $_SESSION["jd_user"]["department"] . "' " . $typeFilter, "s");



        $userResult = Database::operation("SELECT user.fname,user.lname,user.email,user.mobile,user.jid,user.reg_date,attendance.date_time,attendance.description,attendance.id  FROM `attendance`
     INNER JOIN `user` ON `user`.`id`=`attendance`.`user_id` INNER JOIN `position` ON `position`.`id`=`user`.`position_id` INNER JOIN `department` ON `department`.`id`=position.`department_id` WHERE `department`.`name`='" . $_SESSION["jd_user"]["department"] . "'  " . $typeFilter . " LIMIT 25 OFFSET " . $offset, "s");


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
            $message->total = $rowCount;
            $message->marked = $rowCount;

            echo json_encode($message);
        } else {
            $message->message = "oops !! you got nothing";
            $message->type = "error";
            echo json_encode($message);
        }
    }
} else {
}
