<?php

require_once('dbconfig.php');
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function send_otp_email($email, $otp) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'hnynnzarchi@gmail.com'; 
        $mail->Password = 'qvbxfjgvyitkfxry';    
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $mail->Port = 587; 

        $mail->setFrom('hnynnzarchi@gmail.com', 'HnynnZarchiLynn');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP for Password Reset';
        $mail->Body = "Your One-Time Password (OTP) for password reset is: $otp. This OTP is valid for 10 minutes.";

        $mail->send();
        return true;
    } catch (Exception $e) {
        $_SESSION['error_message'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}

session_start(); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);

   
    // $allowed_domain = 'ucsmgy.edu.mm';
    // if (substr($email, -strlen($allowed_domain)) !== $allowed_domain) {
    //     $_SESSION['error_message'] = "Please use your university email address (ucsmgy.edu.mm).";
    //     header("Location: forgot.php");
    //     exit();
    // }

    if ($con) {
        $query = "SELECT * FROM userinfo WHERE username = ? AND email = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $otp = rand(10000000, 99999999);
            $otp_expiration = date("Y-m-d H:i:s", strtotime('+10 minutes'));

            $update_query = "UPDATE userinfo SET otp = ?, otp_expiration = ? WHERE username = ? AND email = ?";
            $update_stmt = $con->prepare($update_query);
            $update_stmt->bind_param("ssss", $otp, $otp_expiration, $username, $email);
            $update_stmt->execute();

            if ($update_stmt->affected_rows > 0) {
                if (send_otp_email($email, $otp)) {
                    echo "<script>
                        alert('OTP has been sent to your email. Please check and enter the OTP to reset your password.');
                        window.location.href = 'reset.php?username={$username}';
                      </script>";
                } else {
                    header("Location: forgot.php"); 
                    exit();
                }
            } else {
                $_SESSION['error_message'] = "Failed to update OTP. Please try again.";
            }

            $update_stmt->close();
        } else {
            $_SESSION['error_message'] = "The username or email you entered does not match our records.";
        }

        $stmt->close();
        $con->close();
    } else {
        $_SESSION['error_message'] = "Database connection failed. Please try again later.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        body{
            background-image: url(g.png);
            background-size: cover;
        }
        .container {
            max-width: 600px;
            margin: 150px auto;
            padding: 20px;
            border: 3px solid #ccc;
            box-shadow: 0 0 30px rgba(0,0,0,0.1);
            border-radius: 8px;
            background-color: white;
            display: flex;
            align-items: center;
        }

        input[type="text"], input[type="email"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        input[type="text"]:focus, input[type="email"]:focus {
            background-color: #ffffe0;
        }

        input[type="submit"] {
            background-color: #4CAF50; 
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            font-weight: bold;
            padding: 20px;
        }
    </style>
</head>
<body>
<div class="container">
        <img src="for.jpg" alt="Forgot Password"style="width:250px;">
        <div class="form-container">
            <h2>Forgot Password</h2>
            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="error">
                    <?php
                    echo $_SESSION['error_message'];
                    unset($_SESSION['error_message']); 
                    ?>
                </div>
            <?php endif; ?>
            <form action="forgot.php" method="POST">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required><br><br>

                <label for="email">Email:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="email" name="email" id="email" required><br><br>

                <input type="submit" value="Submit">
            </form>
        </div>
    </div>
</body>
</html>
</body>
</html>
