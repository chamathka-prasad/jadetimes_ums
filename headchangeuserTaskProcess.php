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

if (isset($_SESSION["jd_user"])) {

    $adminSession = $_SESSION["jd_user"];

    $userTask = $_POST["userTask"];
    $email = $_POST["email"];



    $message = new stdClass();

    if (empty($userTask)) {

        $message->type = "error";
        $message->message = "Task is empty";
    } else {

        $userResults = Database::operation("SELECT * FROM `user` WHERE `user`.`email`='" . $email . "'", "s");
        if ($userResults->num_rows == 1) {

            $user = $userResults->fetch_assoc();
            $taskList = Database::operation("SELECT * FROM `task` WHERE `task`.`user_id`='" . $user["id"] . "'", "s");

            if ($taskList->num_rows == 1) {
                $searchTask = $taskList->fetch_assoc();
                Database::operation("UPDATE `task` SET `task`.`user_task`='" . $userTask . "' WHERE `task`.`id`='" . $searchTask["id"] . "'", "iud");
                $message->type = "success";



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
                $mail->Subject = 'Jade times Daily Task Update';
                $mail->AddEmbeddedImage('assets/img/darkLogo.png', 'logo_cid');
                $bodyContent = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Updated</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 50px auto; background-color: #282828; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); padding: 20px; color: #f4f4f4;">
        <header style="text-align: center; margin-bottom: 30px;">
            <img src="cid:logo_cid" alt="Jade Times Logo" style="max-width: 200px; margin-bottom: 10px;">
        </header>
        <main>
            <h2 style="color: #ffffff;">Your Task Has Changed</h2>
            <p style="color: #cccccc;">We want to inform you that your assigned task has been updated. Please find the details below:</p>
            <div style="margin: 20px 0; padding: 15px; background-color: #333; border-radius: 5px;">
                <p style="font-size: 16px; color: #ffffff;">
                    <strong>Updated Task:</strong>
                </p>
                <p style="color: #ffffff;">'.$userTask.'</p>
            </div>
            <p style="color: #cccccc;">Please review the changes and proceed accordingly.</p>
    
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
                    $message->message = "Task Updated Success. Mail Sending Faild";
                } else {
                    $message->message = "Task Updated Success. Mail Send Complete";
                }
            } else {
                Database::operation("INSERT INTO `task`(`user_task`,`user_id`) VALUES('" . $userTask . "','" . $user["id"] . "')", "iud");
                $message->type = "success";
                $message->message = "Task Added Success";
            }
        } else {
            $message->type = "error";
            $message->message = "Invalid user";
        }
    }
    echo json_encode($message);
}
