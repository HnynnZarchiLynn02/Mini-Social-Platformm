<?php
session_start();
require_once('funs.php');

if (isset($_SESSION["username"])) {
    header("location:home.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kudos CUMGY</title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
          background-color: #E2EAF4;
            background-size: cover;
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .header {
            color: #000;
            padding: 30px;
            text-align: center;
        }
        .heading-text {
            font-weight: bold;
            font-size: 40px;
            margin-bottom: 0;
            text-shadow: 2px 2px 4px black;
        }
        .subheading-text {
            font-size: 1.5em;
        }
        .login-container {
            border: 1px solid black;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 4px 20px #fff;
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            color: white;
            position: relative;
        }
        .login-panel .panel-heading {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
            color: #4e73df;
            text-align: center;
        }
        .login-panel .form-control {
            border-radius: 0.5rem;
            padding: 1rem;
        }
        .login-panel .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
            border-radius: 0.5rem;
            padding: 0.75rem;
            font-size: 3rem;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .login-panel .btn-primary:hover {
            background-color: #5a81e0;
        }
        .footer {
            padding-left: 600px;
        }
        .form-control {
            width: 70%;
            border-radius: 5px;
        }
        .p {
            margin-top: 10px;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            font-weight: bold;
            font-style: italic;
            font-size: 30px;
            position: absolute;
            left: 20px; 
            top: 20px; 
            color: #000;
        }
        .s {
            border: 3px solid black;
            border-radius: 15px;
        }
        .error-message {
            color: red;
            font-weight: bold;
            margin-bottom: 1rem;
            text-align: center;
        }
        .rules-content {
            display: none;
            position: fixed;
            top: 20%;
            left: 50%;
            transform: translate(-50%, -20%);
            background: rgba(255, 255, 255);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            width: 80%;
            max-width: 600px;
            z-index: 1000;
        }
        .rules-content h5 {
            margin-top: 0;
        }
        .rules-content .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #f00;
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            font-size: 20px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div><p class="p"><span class="s">H</span>Kudos</p></div>
    <div class="header">
        <h1 class="heading-text"><span><img src="UCSMGY logo.png" style="width:60px;height:60px;"></span> UCSMGY Social Platform </h1>
    </div>
    <div class="error">
        <?php login(); ?>
    </div>
    <div class="login-container">
        <div id="error-message" class="error-message" style="display: none;">You must accept the rules and policies to proceed.</div>
        <div class="panel-body">
            <form class="formgp" method="post" action="" onsubmit="return handleSubmit();">
                <div class="form-group">
                    <input class="form-control" placeholder="Username" name="username" type="text" required autofocus>
                </div>
                <div class="form-group">
                    <input class="form-control" placeholder="Password" name="password" type="password" required>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember" style="color:black;">
                        I accept the rules and policies.
                    </label>
                    <br><br>
                    <a href="javascript:void(0);" onclick="showRulesContent();" style="color:blue;">View Rules and Policies</a>
                </div>
                <button class="btn btn-primary btn-block mt-3" type="submit" name="submit">Login</button>
                <br>
                <a href="forgot.php" style="color:black;">Forgot Password?</a>
            </form>
        </div>
    </div>
    <div class="footer" style="margin-top:75px;color: #000;">
        <b>Copy@copy;HZCL <span style="color: red;">&#10084;</span> By HZCL</b>
    </div>

    <div class="rules-content" id="rulesContent">
        <button class="close-btn" onclick="hideRulesContent();">&times;</button>
        <h5>Rules and Policies</h5>
        <p>I follow the rules and I never post to attack other people.</p>
        <p>I don't post negative content or attack others' reputations.</p>
        <p>I follow the admin's rules and never violate the group members.</p>
        <p>I accept the rules and policies.</p>
    </div>

    <script>
        function handleSubmit() {
            var acceptCheckbox = document.getElementById('remember');
            if (!acceptCheckbox.checked) {
                document.getElementById('error-message').style.display = 'block';
                return false;
            }
            return true; 
        }

        function showRulesContent() {
            document.getElementById('rulesContent').style.display = 'block';
        }

        function hideRulesContent() {
            document.getElementById('rulesContent').style.display = 'none';
        }
    </script>
</body>
</html>
