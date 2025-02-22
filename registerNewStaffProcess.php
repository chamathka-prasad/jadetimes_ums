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

    $uid = $_POST["uid"];
    $date = $_POST["date"];
    $ptype = $_POST["ptype"];

    $message = new stdClass();
    $regex = '/^\+?\d+$/';
    $today = date("Y-m-d");
    if ($uid == 0) {
        $message->type = "error";
        $message->message = "Select a User";
        echo json_encode($message);
    } else if (empty($date)) {
        $message->type = "error";
        $message->message = "Registred date is empty";
        echo json_encode($message);
    } else if ($ptype == 0) {
        $message->type = "error";
        $message->message = "Select A Payment Method";
        echo json_encode($message);
    } else {

        $paymntTypeid = 0;
        if ($ptype == 1) {
            $paymntTypeid = 1;
        }

        $checkUserAvailableResultSet = Database::operation("SELECT * FROM `user` WHERE `user`.`id`='" . $uid . "'", "s");
        if ($checkUserAvailableResultSet->num_rows != 0) {
            $resultsUser = Database::operation("SELECT * FROM `user` INNER JOIN `staff` ON `staff`.`user_id`=`user`.`id` WHERE `user`.`id`='" . $uid . "'", "s");
            if ($resultsUser->num_rows == 0) {

                $userDetails = $checkUserAvailableResultSet->fetch_assoc();

                Database::operation("INSERT INTO `staff`(`user_id`,`reg_date`,`type`,`earning`,'month_start')VALUES('" . $uid . "','" . $date . "','".$paymntTypeid."','0','".$date."')", "iud");

                $messageEdit = "New Payment Profile Registred Success. ";



                //             if($paymntTypeid==1){


                //             }


                //             $mail = new PHPMailer;
                //             $mail->IsSMTP();
                //             $mail->Host = 'mail.privateemail.com';
                //             $mail->SMTPAuth = true;
                //             $mail->Username = 'hr@jadetimes.com';
                //             $mail->Password = 'u7e%ceDBV!Cm/#5';
                //             $mail->SMTPSecure = 'ssl';
                //             $mail->Port = 465;
                //             $mail->setFrom('hr@jadetimes.com', 'Jade Times');
                //             $mail->addAddress($userDetails["email"]);
                //             $mail->isHTML(true);
                //             $mail->Subject = 'Jade times New Payment Profile';
                //             $mail->AddEmbeddedImage('assets/img/darkLogo.png', 'logo_cid');
                //             $bodyContent = '<!DOCTYPE html>
                // <html lang="en">
                // <head>
                //     <meta charset="UTF-8">
                //     <meta name="viewport" content="width=device-width, initial-scale=1.0">
                //     <title>Staff Member</title>
                // </head>
                // <body style="font-family: Arial, sans-serif; margin: 0; padding: 0;">
                //     <div style="max-width: 600px; margin: 50px auto; background-color: #282828; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); padding: 20px; color: #f4f4f4;">
                //         <header style="text-align: center; margin-bottom: 30px;">
                //             <img src="cid:logo_cid" alt="Jade Times Logo" style="max-width: 200px; margin-bottom: 10px;">
                //         </header>
                //         <main>
                //             <h2 style="color: #ffffff;">Congratulations!</h2>
                //             <p style="color: #cccccc;">We are excited to inform you that you are a Staff Member Now.</p>

                //             <p style="color: #cccccc;">Thanks, <br> The Jadetimes Team</p>
                //         </main>
                //         <footer style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #444444; color: #999999;">
                //             <p style="margin: 0;">&copy; 2024 Jadetimes Media LLC. All rights reserved.</p>
                //         </footer>
                //     </div>
                // </body>
                // </html>
                // ';
                //             $mail->Body    = $bodyContent;

                //             if (!$mail->send()) {

                //                 $message->message = $messageEdit . "Email sending failed";
                //             } else {

                $message->type = "success";
                $message->message = $messageEdit;
                // }


                echo json_encode($message);
            } else {
                $message->type = "error";
                $message->message = "User Already Have A Payment Profile";
                echo json_encode($message);
            }
        } else {
            $message->type = "error";
            $message->message = "InvalidUser";
            echo json_encode($message);
        }
    }
}
