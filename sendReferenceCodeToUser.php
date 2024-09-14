<?php

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

$email = $_POST["email"];

$message = new stdClass();

if (empty($email)) {
    $message->type = "error";
    $message->message = "Email is empty";
    echo json_encode($message);
} else {


    $userResult = Database::operation("SELECT * FROM `user` WHERE `email`='" . $email . "' AND `user`.`user_status_id`='1'", "s");
    if ($userResult->num_rows == 1) {

        $code = "JT" . uniqid();

        Database::operation("UPDATE `user` SET `ref_no`='" . $code . "' WHERE `email`='" . $email . "'", "iud");

        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->Host = 'ums.jadetimes.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'no-reply@ums.jadetimes.com';
        $mail->Password = 'jadeTimesEmailSystem';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom('no-reply@ums.jadetimes.com', 'Jade Times');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Jade times User Verification Code For Password Change';
        $mail->AddEmbeddedImage('assets/img/darkLogo.png', 'logo_cid');
        $bodyContent = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #171718; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 50px auto; background-color: #282828; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); padding: 20px; color: #f4f4f4;">
        <header style="text-align: center; margin-bottom: 30px;">
            <img src="cid:logo_cid" alt="Jade Times Logo" style="max-width: 200px; margin-bottom: 10px;">
        </header>
        <main>
            <h2 style="color: #ffffff;">Forgot Your Password?</h2>
            <p style="color: #cccccc;">No worries! We received a request to reset your password. Please use the code below to reset your password:</p>
            <div style="text-align: center; margin: 20px 0;">
                <span style="display: inline-block; padding: 10px 20px; font-size: 20px; color: #ffffff; background-color: #444444; border-radius: 5px;">'.$code.'</span>
            </div>
            <p style="color: #cccccc;">If you did not request a password reset, please ignore this email or contact support if you have questions.</p>
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
            $message->type = "error";
            $message->message = "Verification  code sending failed";
            echo json_encode($message);
        } else {

            $message->type = "success";
            $message->message = "verification code sent to email";
            echo json_encode($message);
        }
    } else {
        $message->type = "error";
        $message->message = "Invalid Email";
        echo json_encode($message);
    }
}
