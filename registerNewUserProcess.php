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

require "connection.php";
require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;

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
    $jtId = $_POST["jtid"];

    $gender = $_POST["gender"];
    $positionId = $_POST["position"];
    $regDate = $_POST["regDate"];

    $duration = $_POST["duration"];
    $linkdin = $_POST["linkdin"];

    $no = $_POST["no"];
    $line1 = $_POST["line1"];
    $line2 = $_POST["line2"];
    $city = $_POST["city"];
    $country = $_POST["country"];


    $password = $_POST["password"];
    $type = $_POST["type"];


    $message = new stdClass();
    $regex = '/^\+?\d+$/';
    $today = date("Y-m-d");
    if (empty($fname)) {
        $message->type = "error";
        $message->message = "first name is empty";
        echo json_encode($message);
    } else if (empty($lname)) {
        $message->type = "error";
        $message->message = "last name is empty";
        echo json_encode($message);
    } else if (empty($jtId)) {
        $message->type = "error";
        $message->message = "Jade Times Id is empty";
        echo json_encode($message);
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message->type = "error";
        $message->message = "email is invalid";
        echo json_encode($message);
    } else if (!empty($mobile) && preg_match($regex, $mobile) != 1) {
        $message->type = "error";
        $message->message = "Mobile number is invalid";
        echo json_encode($message);
    } else if (!empty($dob) && $today < $dob) {
        $message->type = "error";
        $message->message = "Invalid Birth Day";
        echo json_encode($message);
    } else if (empty($regDate)) {
        $message->type = "error";
        $message->message = "Register Date is Empty";
        echo json_encode($message);
    } else if ($today < $regDate) {
        $message->type = "error";
        $message->message = "Invalid Register Date";
        echo json_encode($message);
    } else if (empty($positionId) || $positionId == "0") {
        $message->type = "error";
        $message->message = "Select the User Position";
        echo json_encode($message);
    } else if ((!empty($no) || !empty($line1) || !empty($line2) || !empty($city) || $country != 0) && (empty($line1) || empty($city) || $country == 0)) {
        $message->type = "error";
        $message->message = "If you are adding an address to the user     line1, city and country must be filled or selected. Also, you can register a user without adding an address by keeping the fields empty and disselecting.";
        echo json_encode($message);
    } else {


        $resultsUser = Database::operation("SELECT * FROM `user` WHERE `user`.`email`='" . $email . "' OR `user`.`jid`='" . $jtId . "'", "s");
        if ($resultsUser->num_rows == 0) {

            $userTypeId = "1";
            if (empty($type)) {
                $userTypeId = '1';
            } else {
                $userTypeId = $type;
            }

            $columns = "`fname`,`lname`,`jid`,`email`,`reg_date`,`position_id`,`password`,`type_id`,`user_status_id`";
            $query = "'" . $fname . "','" . $lname . "','" . $jtId . "','" . $email . "','" . $regDate . "','" . $positionId . "','" . $password . "','" . $userTypeId . "','1'";
            if (!empty($sname)) {
                $columns = $columns . ",`sname`";
                $query = $query . ",'" . $sname . "'";
            }
            if (!empty($mname)) {
                $columns = $columns . ",`mname`";
                $query = $query . ",'" . $mname . "'";
            }
            if (!empty($mobile)) {
                $columns = $columns . ",`mobile`";
                $query = $query . ",'" . $mobile . "'";
            }
            if (!empty($nic)) {
                $columns = $columns . ",`nic`";
                $query = $query . ",'" . $nic . "'";
            }
            if (!empty($dob)) {
                $columns = $columns . ",`dob`";
                $query = $query . ",'" . $dob . "'";
            }
            if ($gender != 0) {
                $columns = $columns . ",`gender_id`";
                $query = $query . ",'" . $gender . "'";
            }
            if (!empty($duration)) {
                $columns = $columns . ",`duration`";
                $query = $query . ",'" . $duration . "'";
            }
            if (!empty($linkdin)) {
                $columns = $columns . ",`linkdin`";
                $query = $query . ",'" . $linkdin . "'";
            }



            $message->type = "success";


            $fullQuery = "INSERT INTO `user`(" . $columns . ") VALUES (" . $query . ")";
            Database::operation($fullQuery, "iud");
            if (!empty($line1) && !empty($city) && $country != 0) {

                $addressInputUserResultSet = Database::operation("SELECT * FROM `user` WHERE `user`.`email`='" . $email . "'", "s");

                if ($addressInputUserResultSet->num_rows == 1) {
                    $addressUser = $addressInputUserResultSet->fetch_assoc();

                    Database::operation("INSERT INTO `address`(`no`,`line1`,`line2`,`city`,`country_id`,`user_id`)VALUES('" . $no . "','" . $line1 . "','" . $line2 . "','" . $city . "','" . $country . "','" . $addressUser["id"] . "')", "iud");
                }
            }


            $messageEdit = "New user Registred Success. ";

           


            $mail = new PHPMailer;
            $mail->IsSMTP();
            $mail->Host = 'mail.specialgraphics.us';
            $mail->SMTPAuth = true;
            $mail->Username = 'no-reply@ums.jadetimes.com';
            $mail->Password = 'jadeTimesEmailSystem';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            $mail->setFrom('no-reply@ums.jadetimes.com', 'Jade Times');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Jade times UMS system access';
            $mail->AddEmbeddedImage('assets/img/darkLogo.png', 'logo_cid');
            $bodyContent = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Created</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 50px auto; background-color: #282828; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); padding: 20px; color: #f4f4f4;">
        <header style="text-align: center; margin-bottom: 30px;">
            <img src="cid:logo_cid" alt="Jade Times Logo" style="max-width: 200px; margin-bottom: 10px;">
        </header>
        <main>
            <h2 style="color: #ffffff;">Welcome to Jadetimes UMS System!</h2>
            <p style="color: #cccccc;">We are excited to inform you that your account has been successfully created. Here are your login details:</p>
            <div style="margin: 20px 0;">
                <p style="font-size: 16px; color: #ffffff;">
                    <strong>Email:</strong> 
                    <span style="color: #ffffff; text-decoration: none;">
                        <a href="mailto:<?php echo $email; ?>" style="color: #ffffff; text-decoration: none;">'.$email.'</a>
                    </span>
                </p>
                <p style="font-size: 16px; color: #ffffff;">
                    <strong>Password:</strong> 
                    <span style="color: #ffffff; text-decoration: none;">
                        '.$password.'
                    </span>
                </p>
            </div>
            <p style="color: #cccccc;">You can now log in to your account and start exploring our services.</p>
            <p style="text-align: center; margin: 20px 0;">
                <a href="https://ums.jadetimes.com/index.php" style="color: #007BFF; text-decoration: none; background-color: #ffffff; padding: 10px 20px; border-radius: 5px;">Log In to Jade Times</a>
            </p>
            <p style="color: #cccccc;">Thanks, <br> The Jadetimes Team</p>
        </main>
        <footer style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #444444; color: #999999;">
            <p style="margin: 0;">&copy; 2024 Jadetimes Media LLC. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
';
            $mail->Body    = $bodyContent;

            if (!$mail->send()) {

                $message->message = $messageEdit . "Verification  code sending failed";
            } else {

                $message->type = "success";
                $message->message = $messageEdit . "verification code sent to email";
            }


            echo json_encode($message);
        } else {
            $message->type = "error";
            $userSearchDetails = $resultsUser->fetch_assoc();
            if ($userSearchDetails["email"] == $email) {
                $message->message = "This email is already registred on the system.Try a different one";
            } else {
                $message->message = "This Jade Times Id is already registred on the system.Try a different one";
            }

            echo json_encode($message);
        }
    }
}
