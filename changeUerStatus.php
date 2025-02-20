<?php
require "connection.php";
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

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;

if (isset($_SESSION["jd_admin"])) {
    $userSession = $_SESSION["jd_admin"];

    $status = $_POST["status"];
    $email = $_POST["email"];
    $letterSubject = $_POST["letterSubject"];
    $letterBody = $_POST["letterBody"];


    $message = new stdClass();

    $results = Database::operation("SELECT * FROM `user` WHERE `user`.`email`='" . $email . "'", "s");

    if ($results->num_rows == 1) {

        $statusChangeId = 2;
        $reson = "";
        if ($status == "active") {
            $statusChangeId = 1;
            Database::operation("UPDATE `user` SET `user_status_id`='" . $statusChangeId . "' WHERE `user`.`email`='" . $email . "'", "iud");
        } else if ($status == "deactive") {
            $statusChangeId = 2;
            Database::operation("UPDATE `user` SET `user_status_id`='" . $statusChangeId . "',`suspend_reason`='" . $letterSubject . "' WHERE `user`.`email`='" . $email . "'", "iud");


            // $reson= ",`suspend_reason`=".$letterSubject;



            $mail = new PHPMailer;
            $mail->IsSMTP();
            $mail->Host = 'mail.privateemail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'hr@jadetimes.com';
            $mail->Password = 'u7e%ceDBV!Cm/#5';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            $mail->setFrom('hr@jadetimes.com', 'Jade Times');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Jade times UMS Profile Suspension';
            $mail->AddEmbeddedImage('assets/img/darkLogo.png', 'logo_cid');
            $bodyContent = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Suspension Notice</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 50px auto; background-color: #282828; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); padding: 20px; color: #f4f4f4;">
        <header style="text-align: center; margin-bottom: 30px;">
            <img src="cid:logo_cid" alt="Jade Times Logo" style="max-width: 200px; margin-bottom: 10px;">
        </header>
        <main>
            <h1 style="color: #ffffff; text-align: center;">Suspension Notice</h1>
            <h2 style="color: #ffffff;">Your Profile Has Been Suspended</h2>
            <p style="color: #cccccc;">We regret to inform you that your account has been suspended due to the following reason:</p>
            <div style="margin: 20px 0; padding: 15px; background-color: #333; border-radius: 5px;">
                <p style="font-size: 16px; color: #ffffff;text-decoration:underline">
                    <strong>' . $letterSubject . '</strong>
                </p>
                <p style="color: #ffffff;">' . $letterBody . '</p>
            </div>
            <p style="color: #cccccc;">For more information, please refer to the following policies:</p>
            <ul style="color: #cccccc;">
                <li><a href="https://www.jadetimes.com/internship-policies" style="color: #007BFF; text-decoration: none;">Internship Policies</a></li>
                <li><a href="https://www.jadetimes.com/terms-and-conditions" style="color: #007BFF; text-decoration: none;">Jadetimes Terms and Conditions</a></li>
            </ul>
            <div style="margin-top: 20px; padding: 15px; background-color: #444; border-radius: 5px;">
                <h3 style="color: #ffffff; text-align: center;">How to Recover Your Account</h3>
                <p style="color: #cccccc; text-align: center;">
                    Contact HR Department <br>
                    Contact Your Department Coordinator <br>
                    <strong>Email:</strong> <a href="mailto:hr@jadetimes.com" style="color: #007BFF; text-decoration: none;">hr@jadetimes.com</a>
                </p>
            </div>
            <p style="color: #cccccc;">If you believe this is a mistake or want to appeal, please reach out to the appropriate contacts above.</p>
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
                $message->message = "Suspended Success. Mail Sending Faild";
            } else {
                $message->message = "Suspended Success. Mail Send Complete";
            }
        }


        $message->type = "success";
        $message->message = "Status Change Success";
        echo json_encode($message);
    } else {



        $message->type = "error";
        $message->message = "Already marked for today";
        echo json_encode($message);
    }
}
