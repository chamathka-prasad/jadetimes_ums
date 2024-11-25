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


    $sname = $_POST["sname"];
    $fname = $_POST["fname"];
    $mname = $_POST["mname"];
    $lname = $_POST["lname"];

    $email = $_POST["email"];
    $mobile = $_POST["mobile"];
    $nic = $_POST["nic"];
    $dob = $_POST["dob"];

    $gender = $_POST["gender"];
    $position = $_POST["position"];
    $type = $_POST["type"];
    $jid = $_POST["jid"];

    $duration = $_POST["duration"];
    $linkdin = $_POST["linkdin"];

    $no = $_POST["no"];
    $line1 = $_POST["line1"];
    $line2 = $_POST["line2"];
    $city = $_POST["city"];
    $type = $_POST["type"];
    $countryId = $_POST["country"];

    $message = new stdClass();
    $regex = '/^\+?\d+$/';

    if (empty($fname)) {
        $message->type = "error";
        $message->message = "first name is empty";
        echo json_encode($message);
    } else if (empty($lname)) {
        $message->type = "error";
        $message->message = "last name is empty";
        echo json_encode($message);
    } else if (empty($email)) {
        $message->type = "error";
        $message->message = "email is invalid Reload the page";
        echo json_encode($message);
    }

    // else if (preg_match($regex, $mobile) != 1) {
    //     $message->type = "error";
    //     $message->message = "Mobile number is invalid";
    //     echo json_encode($message);
    // } else if (empty($nic)) {
    //     $message->type = "error";
    //     $message->message = "Nic is empty";
    //     echo json_encode($message);
    // } else if (empty($dob)) {
    //     $message->type = "error";
    //     $message->message = "Dob is empty";
    //     echo json_encode($message);
    // } else if (empty($jid)) {
    //     $message->type = "error";
    //     $message->message = "Jades Id is empty ";
    //     echo json_encode($message);
    // } 
    else if (empty($position)) {
        $message->type = "error";
        $message->message = "Select a position";
        echo json_encode($message);
    } else if (empty($type)) {
        $message->type = "error";
        $message->message = "Select a user type";
        echo json_encode($message);
    } else if ((empty($line1) || empty($city) || $countryId == 0)) {
        $message->type = "error";
        $message->message = "If you are adding an address to the user     line1, city and country must be filled or selected. Also, you can register a user without adding an address by keeping the fields empty and disselecting.";
        echo json_encode($message);
    } else {



        $resultsUser = Database::operation("SELECT * FROM `user` WHERE `user`.`email`='" . $email . "'", "s");
        if ($resultsUser->num_rows == 1) {

            $state = false;
            $userDetails = $resultsUser->fetch_assoc();

            $typemessage = "";
            $typeQuery = "";


            if ($userDetails["jid"] == $jid) {
                $state = true;
            } else {
                $jidResultsUser = Database::operation("SELECT * FROM `user` WHERE `user`.`jid`='" . $jid . "'", "s");
                if ($jidResultsUser->num_rows > 0) {

                    $message->type = "error";
                    $message->message = "new Jades Id is already Registred.";
                    echo json_encode($message);
                    $state = false;
                } else {
                    $typeQuery = ",`user`.`jid`='" . $jid . "'";
                    $state = true;
                }
            }


            if ($state) {


                if ($userDetails["type_id"] != $type) {
                    if ($sessionAdmin["user_type"] == "superAdmin") {
                        $typeQuery = $typeQuery . ",`user`.`type_id`='" . $type . "'";
                    } else {
                        if ($type != 3) {
                            $typeQuery = $typeQuery . ",`user`.`type_id`='" . $type . "'";
                        } else {
                            $typemessage = " But Only super admin can change the user type";
                        }
                    }
                }
                $updateQuery = "";
                if (!empty($dob)) {
               
                    $updateQuery = ",`user`.`dob`='" . $dob . "'";
                }

                Database::operation("UPDATE `user` SET `user`.`sname`='" . $sname . "',`user`.`fname`='" . $fname . "',`user`.`mname`='" . $mname . "',`user`.`lname`='" . $lname . "',`user`.`mobile`='" . $mobile . "',`user`.`nic`='" . $nic . "',`user`.`duration`='" . $duration . "',`user`.`linkdin`='" . $linkdin . "',`user`.`gender_id`='" . $gender . "',`user`.`position_id`='" . $position . "' " . $typeQuery . " ".$updateQuery." WHERE user.email='" . $email . "'", "iud");



                $addressResults = Database::operation("SELECT * FROM `address` WHERE `address`.`user_id`='" . $userDetails["id"] . "'", "s");
                if ($addressResults->num_rows == 1) {

                    Database::operation("UPDATE `address` SET `address`.`no`='" . $no . "',`address`.`line1`='" . $line1 . "',`address`.`line2`='" . $line2 . "',`address`.`city`='" . $city . "',`address`.`country_id`='" . $countryId . "' WHERE `address`.`user_id`='" . $userDetails["id"] . "'", "iud");
                } else {
                    Database::operation("INSERT INTO `address`(`no`,`line1`,`line2`,`city`,`country_id`,`user_id`)VALUES('" . $no . "','" . $line1 . "','" . $line2 . "','" . $city . "','" . $countryId . "','" . $userDetails["id"] . "')", "iud");
                }




                if (isset($_FILES["img"])) {



                    $img = $_FILES["img"];


                    $ext = pathinfo($img["name"], PATHINFO_EXTENSION);


                    $img["type"];

                    $fileName = uniqid() . $sessionAdmin["id"];
                    $savePath = $fileName . "." . $ext;
                    $path = "./resources/profileImg/" . $fileName . "." . $ext;

                    $profileImgResult = Database::operation("SELECT * FROM `profile_image` WHERE `user_id`='" .  $userDetails["id"] . "'", "s");
                    if ($profileImgResult->num_rows == 1) {
                        Database::operation("UPDATE `profile_image` SET `profile_image`.`name`='" . $savePath . "' WHERE `user_id`='" .  $userDetails["id"] . "'", "iud");
                    } else {

                        Database::operation("INSERT INTO `profile_image`(`name`,`user_id`)VALUES('" . $savePath . "','" . $userDetails["id"] . "')", "iud");
                    }
                    move_uploaded_file($img["tmp_name"], $path);
                }



                if ($userDetails["id"] == $sessionAdmin["id"]) {
                    $results = Database::operation("SELECT `user`.`id`,`user`.`email`,`user`.`password`,`user`.`fname`,`user`.`lname`,`user`.`jid`,`type`.`name` AS `user_type`,`position`.`name` AS `position`,`department`.`name` AS `department`,`profile_image`.`name` AS `imgPath` FROM `user` INNER JOIN `type` ON  `type`.`id`=`user`.`type_id` INNER JOIN `user_status` ON `user`.`user_status_id`=`user_status`.`id` INNER JOIN `position` ON `position`.`id`=`user`.`position_id` INNER JOIN `department` ON `department`.`id`=`position`.`department_id` LEFT JOIN  `profile_image` ON `profile_image`.`user_id`=`user`.`id` WHERE `type`.`name` IN ('admin','superAdmin') AND `user`.`id`='" . $userDetails["id"] . "'  AND `user_status`.`name`='ACTIVE'", "s");

                    if ($results->num_rows == 1) {
                        $adminDetails = $results->fetch_assoc();


                        $_SESSION["jd_admin"] = $adminDetails;
                    }
                }
                $message->type = "success";
                $message->message = "Profile Update Success" . $typemessage;
                echo json_encode($message);
            }
        } else {
            $message->type = "error";
            $message->message = "Invalid Email";
            echo json_encode($message);
        }
    }
}
