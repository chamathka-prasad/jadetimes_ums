<?php
session_start();
require "connection.php";

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


    $sessionAdmin = $_SESSION["jd_admin"];
    $message = new stdClass();
    $user = $_POST["user"];


    if (empty($user)) {
        $message->type = "error";
        $message->message = "Select A User";
        echo json_encode($message);
    } else if (!isset($_FILES["cetificate"])) {
        $message->type = "error";
        $message->message = "Upload A Cetificate";
        echo json_encode($message);
    } else if (!isset($_FILES["serviceLetter"])) {
        $message->type = "error";
        $message->message = "Upload the Servicce Letter";
        echo json_encode($message);
    } else {



        $resultsUser = Database::operation("SELECT * FROM `user` WHERE `user`.`id`='" . $user . "'", "s");
        if ($resultsUser->num_rows == 1) {

            $userDetails = $resultsUser->fetch_assoc();

            $d = new DateTime();
            $tz = new DateTimeZone("Asia/Colombo");
            $d->setTimezone($tz);
            $date=$d->format("Y-m-d H:i:s");

            $fid = uniqid() . $sessionAdmin["id"];

            Database::operation("INSERT INTO `user_feedback`(`feedback`,`rating`,`datetime`,`status`,`user_feedback_type_id`,`user_id`,`fid`)
            VALUES('','0','" . $date . "','0',1,'" . $user . "','" . $fid . "')", "iud");


            $cetificate = $_FILES["cetificate"];
            $serviceLetter = $_FILES["serviceLetter"];

            // 


            $feedbackResult = Database::operation("SELECT * FROM `user_feedback` WHERE `fid`='" .  $fid . "'", "s");
            if ($feedbackResult->num_rows == 1) {
                $feedbackfromDb=$feedbackResult->fetch_assoc();

                $ext = pathinfo($cetificate["name"], PATHINFO_EXTENSION);


                $fileName = uniqid() . $sessionAdmin["id"];
                $savePath = $fileName . "." . $ext;
                $path = "./resources/documents/" . $fileName . "." . $ext;
                move_uploaded_file($cetificate["tmp_name"], $path);
                Database::operation("INSERT INTO `attachments`(`path`,`user_feedback_id`,`document_type_id`)VALUES('" . $savePath . "','" . $feedbackfromDb["id"] . "','1')", "iud");
            

                $ext2 = pathinfo($serviceLetter["name"], PATHINFO_EXTENSION);


                $fileName2 = uniqid() . $sessionAdmin["id"];
                $savePath2 = $fileName2 . "." . $ext2;
                $path2 = "./resources/documents/" . $fileName2 . "." . $ext2;
                move_uploaded_file($serviceLetter["tmp_name"], $path2);

                Database::operation("INSERT INTO `attachments`(`path`,`user_feedback_id`,`document_type_id`)VALUES('" . $savePath2 . "','" . $feedbackfromDb["id"] . "','2')", "iud");
            
            
            } 
        
            // 

           
            $message->type = "success";
            $message->message = "Cetificate Upload Success";
            echo json_encode($message);
        } else {
            $message->type = "error";
            $message->message = "Invalid Email";
            echo json_encode($message);
        }
    }
}
