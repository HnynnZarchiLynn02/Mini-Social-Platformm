<?php
require_once('dbconfig.php');


function isStrongPassword($password) {
    $password_pattern = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/";
    return preg_match($password_pattern, $password);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username'] ?? '');
    $otp = trim($_POST['otp'] ?? '');
    $new_password = trim($_POST['new_password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');

    if ($new_password !== $confirm_password) {
        echo "<script>alert('Passwords do not match. Please try again.');</script>";
    } elseif (!isStrongPassword($new_password)) {
        echo "<script>alert('Password is not strong enough. It must include uppercase, lowercase, numbers, special characters, and be at least 8 characters long.');</script>";
    } else {
        $query = "SELECT otp, otp_expiration FROM userinfo WHERE username = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if ($row['otp'] === $otp && strtotime($row['otp_expiration']) > time()) {
                
                $update_query = "UPDATE userinfo SET password = ?, otp = NULL, otp_expiration = NULL WHERE username = ?";
                $update_stmt = $con->prepare($update_query);
                $update_stmt->bind_param("ss", $new_password, $username);
                $update_stmt->execute();

                if ($update_stmt->affected_rows > 0) {
                    echo "<script>
                            alert('Your password has been reset successfully.');
                            window.location.href = 'index.php';
                          </script>";
                } else {
                    echo "<script>alert('Failed to reset the password. Please try again.');</script>";
                }

                $update_stmt->close();
            } else {
                echo "<script>alert('Invalid OTP or OTP has expired. Please try again.');</script>";
            }
        } else {
            echo "<script>alert('No user found with that username.');</script>";
        }

        $stmt->close();
    }
    $con->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url(fo4.jpg);
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        
        .container {
            width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
            background-color: #fff;
            display: flex; 
        }

        .image-container {
            flex: 1; 
            padding-right: 20px;
        }

        .image-container img {
            margin-top: 80px;
            width: 100%;
            border-radius: 8px; 
        }

        .form-container {
            flex: 2; 
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 15px;
            box-sizing: border-box;
            transition: background-color 0.3s ease;
        }

        input[type="text"]:focus, input[type="password"]:focus {
            background-color: #ffffe0; 
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="image-container">
            <img src="res.jpg" alt="Reset Password Image">
        </div>
        <div class="form-container">
            <h2>Reset Password</h2>
            <form action="reset.php" method="POST">
                <?php if (isset($_GET['username'])): ?>
                    <input type="hidden" name="username" value="<?php echo htmlspecialchars($_GET['username']); ?>">
                <?php else: ?>
                    <p class="error">Username not provided in the URL.</p>
                <?php endif; ?>

                <label for="otp">OTP:</label>
                <input type="text" name="otp" id="otp" required><br><br>

                <label for="new_password">New Password:</label>
                <input type="password" name="new_password" id="new_password" required><br><br>

                <label for="confirm_password">Confirm New Password:</label>
                <input type="password" name="confirm_password" id="confirm_password" required><br><br>

                <input type="submit" value="Reset Password">
            </form>
        </div>
    </div>
</body>
</html>
