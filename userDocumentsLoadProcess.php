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
            $typeFilter = "WHERE `document`.`document_type_id` ='" . $status . "'";
        } else {

            $typeFilter = $typeFilter . " AND `document`.`document_type_id` ='" . $status . "'";
        }
    }





    $offset = ($page - 1) * 25;

    $message = new stdClass();




    $userResultCount = Database::operation("SELECT COUNT(*) AS total_rows FROM `document`
     INNER JOIN `user` ON `user`.`id`=`document`.`user_id` " . $typeFilter, "s");



    $userResult = Database::operation("SELECT document.id,document.path,document.datetime,user.fname,user.lname,user.email,document_type.name  FROM `document`
    INNER JOIN `document_type` ON `document`.`document_type_id`=`document_type`.`id`
     INNER JOIN `user` ON `user`.`id`=`document`.`user_id` " . $typeFilter . " LIMIT 25 OFFSET " . $offset, "s");


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
