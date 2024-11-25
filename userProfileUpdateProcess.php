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

if (isset($_SESSION["jd_user"])) {


    $sessionUser = $_SESSION["jd_user"];


    $email = $_POST["email"];


    $no = $_POST["no"];
    $line1 = $_POST["line1"];
    $line2 = $_POST["line2"];
    $city = $_POST["city"];
    $countryId = $_POST["country"];

    $message = new stdClass();
    $regex = '/^\+?\d+$/';


    if (empty($line1)) {
        $message->type = "error";
        $message->message = "Line1 is empty";
        echo json_encode($message);
    } else if (empty($city)) {
        $message->type = "error";
        $message->message = "city is empty";
        echo json_encode($message);
    } else if (empty($countryId)) {
        $message->type = "error";
        $message->message = "Select a country";
        echo json_encode($message);
    } else {


        $Forward = false;
        if ($sessionUser["email"] == $email) {
            $Forward = true;
        } else {

            $resultsUser = Database::operation("SELECT * FROM `user` WHERE `user`.`email`='" . $email . "'", "s");
            if ($resultsUser->num_rows == 0) {
                $Forward = true;
            } else {
                $message->type = "error";
                $message->message = "This email is already registred on the system.Try a different one";
                echo json_encode($message);
            }
        }


        if ($Forward) {


            $addressResults = Database::operation("SELECT * FROM `address` WHERE `address`.`user_id`='" . $sessionUser["id"] . "'", "s");
            if ($addressResults->num_rows == 1) {

                Database::operation("UPDATE `address` SET `address`.`no`='" . $no . "',`address`.`line1`='" . $line1 . "',`address`.`line2`='" . $line2 . "',`address`.`city`='" . $city . "',`address`.`country_id`='" . $countryId . "' WHERE `address`.`user_id`='" . $sessionUser["id"] . "'", "iud");
            } else {
                Database::operation("INSERT INTO `address`(`no`,`line1`,`line2`,`city`,`country_id`,`user_id`)VALUES('" . $no . "','" . $line1 . "','" . $line2 . "','" . $city . "','" . $countryId . "','" . $sessionUser["id"] . "')", "iud");
            }




            if (isset($_FILES["img"])) {



                $img = $_FILES["img"];


                $ext = pathinfo($img["name"], PATHINFO_EXTENSION);


                $img["type"];

                $fileName = uniqid() . $sessionUser["id"];
                $savePath = $fileName . "." . $ext;
                $path = "./resources/profileImg/" . $fileName . "." . $ext;

                $profileImgResult = Database::operation("SELECT * FROM `profile_image` WHERE `user_id`='" . $sessionUser["id"] . "'", "s");
                if ($profileImgResult->num_rows == 1) {
                    Database::operation("UPDATE `profile_image` SET `profile_image`.`name`='" . $savePath . "' WHERE `profile_image`.`user_id`='" . $sessionUser["id"] . "'", "iud");
                } else {

                    Database::operation("INSERT INTO `profile_image`(`name`,`user_id`)VALUES('" . $savePath . "','" . $sessionUser["id"] . "')", "iud");
                }
                move_uploaded_file($img["tmp_name"], $path);
            }

            $results = Database::operation("SELECT `user`.`id`,`user`.`email`,`user`.`password`,`user`.`fname`,`user`.`lname`,`user`.`jid`,`type`.`name` AS `user_type`,`position`.`name` AS `position`,`department`.`name` AS `department`,`profile_image`.`name` AS `imgPath` FROM `user` INNER JOIN `type` ON  `type`.`id`=`user`.`type_id` INNER JOIN `user_status` ON `user`.`user_status_id`=`user_status`.`id` INNER JOIN `position` ON `position`.`id`=`user`.`position_id` INNER JOIN `department` ON `department`.`id`=`position`.`department_id` LEFT JOIN  `profile_image` ON `profile_image`.`user_id`=`user`.`id` WHERE `user`.`id`='" . $sessionUser["id"] . "' AND `user_status`.`name`='ACTIVE'", "s");

            if ($results->num_rows == 1) {
                $adminDetails = $results->fetch_assoc();

                $_SESSION["jd_user"] = $adminDetails;
                $message->type = "success";
                $message->message = "Profile Update Success";
                echo json_encode($message);
            } else {

                $message->type = "error";
                $message->message = "Some thing wrong please try again";
                echo json_encode($message);
            }
        }
    }
}
