<?php

session_start();

/* SMTP */

require 'smtp/PHPMailer.php';
require 'smtp/SMTP.php';
require 'smtp/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$MAIL = new PHPMailer();

$MAIL->isSMTP();
$MAIL->SMTPAuth = true;
$MAIL->SMTPSecure = 'tls';
$MAIL->Host = 'smtp.gmail.com';
$MAIL->Port = '587';
$MAIL->Username = '00phub23@gmail.com';
$MAIL->Password = '09465287111';
$MAIL->SetFrom('00phub23@gmail.com');
$MAIL->isHTML();
$MAIL->FromName = 'Programmers Hub';

$BASE_URL = "https://localhost/email_verification_sample/";

$server = "localhost";
$user = "root";
$pass = "";
$database = "email_verification";

$conn = mysqli_connect($server, $user, $pass, $database);

if (!$conn) {
    die("Error Database!");
}

/* REGISTER ACCOUNT */

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = md5($password);
    $verification_code = md5(rand(0, 32767));

    $MAIL_BODY =

        "<p>Hi " . $name . ",</p>

        <p>We just need to verify your email address before you can access Sample Website.</p>

        <p>Verify your email address " . $BASE_URL . "server.php?activation_code=" . $verification_code . "</p> <br>

        <p>Thanks! &#8211; The Sample Website Team</p>";

    $MAIL->Subject = 'Activate Account';
    $MAIL->Body = $MAIL_BODY;
    $MAIL->AddAddress($email);

    if ($MAIL->Send()) 
    {
        $sql = "INSERT INTO `users` (`name`, `email`, `password`, `verification_code`) VALUES ('" . $name . "', '" . $email . "', '" . $password . "', '" . $verification_code . "')";
        $result = mysqli_query($conn, $sql);

        $_SESSION['message'] = "Details Saved!";
        $_SESSION['alert_type'] = "alert-success";
    } 
    
    else 
    {
        $_SESSION['message'] = "There is are problems in saving your account!";
        $_SESSION['alert_type'] = "alert-danger";
    }
}

/* Verify Account */
if (isset($_GET['activation_code']))
{
    $sql = "SELECT `verification_code`, `is_verified` FROM `users` WHERE `verification_code` = '". $_GET['activation_code'] ."' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    $data = mysqli_fetch_array($result);

    if (mysqli_num_rows($result))
    {
        if ($data['is_verified'] == 0)
        {
            $sql = "UPDATE `users` SET `is_verified` = '1' WHERE `verification_code` = '". $_GET['activation_code'] ."'";
            $result = mysqli_query($conn, $sql);

            $_SESSION['message'] = "Email is Verified! You can now Login";
            $_SESSION['alert_type'] = "alert-success";
        }

        else
        {
            $_SESSION['message'] = "This email is already verified";
            $_SESSION['alert_type'] = "alert-warning";
        }

        header("location: index.php");
    }
}
