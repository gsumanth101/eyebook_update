<?php
// session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);
$message = $message ?? ''; // Ensure $message is defined

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knowbots</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/views/public/assets/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/views/public/assets/images/android-chrome-512x512.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/views/public/assets/images/android-chrome-192x192.png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/views/public/assets/styles/core.css">
    <link rel="stylesheet" type="text/css" href="/views/public/assets/styles/icon-font.min.css">
    <link rel="stylesheet" type="text/css" href="/views/public/assets/styles/style.css">
    <style>
        h5 {
            color: blue;
        }
        .custom-checkbox {
            margin-top: 0px;
            margin-bottom: 5px;
        }
    </style>
</head>
<body class="login-page">
<div class="login-header box-shadow">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <nav class="navbar navbar-light">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <h2 style="font-family: cursive;">Knowbots</h2>
                </a>
            </div>
        </nav>
    </div>
</div>
<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 col-lg-7">
                <img src="/views/public/assets/images/login-page-img.webp" alt="">
            </div>
            <div class="col-md-6 col-lg-5">
                <div class="login-box bg-light box-shadow border-radius-12">
                    <div class="login-title">
                        <h2 class="text-center text-primary" style="font-family: cursive;">Login</h2>
                    </div>
                    <form id="loginForm" action="/login" method="POST">
                        <div class="input-group custom">
                            <input type="text" class="form-control form-control-lg" placeholder="Username/Email id" name="username" id="username" required>
                        </div>
                        <div class="input-group custom">
                            <input type="password" class="form-control form-control-lg" placeholder="**********" name="password" id="password" required>
                        </div>
                        <div class="input-group custom custom-checkbox">
                            <input type="checkbox" name="agree" id="agree" required>
                            <label for="agree" class="ml-2">I agree to the <a href="/#privacy-policy" style="color: blue;">Privacy Policy</a></label>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="input-group mb-0">
                                    <input class="btn btn-primary btn-lg btn-block" name="login" id="login" type="submit" value="Sign In">
                                </div>
                                <div class="col-6 mt-3 float-right">
                                    <div class="forgot-password"><a href="/forgot_password" style="color: blue;">Forgot Password?</a></div>
                                </div>
                            </div>
                            <div style="color: red;">
                                <?php echo htmlspecialchars($message); ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><br>
    </div>
</div>
<div style="bottom:0; background-color: #ffffff; color: #7b09df; text-align: center; padding: 10px 0; font-size: 0.8em;">
    <p>Developed and maintained by <br> <a href="about.html">Phemesoft</a></p>
</div>
<script src="/views/public/assets/scripts/core.js"></script>
<script src="/views/public/assets/scripts/script.min.js"></script>
<script src="/views/public/assets/scripts/process.js"></script>
<script src="/views/public/assets/scripts/layout-settings.js"></script>
</body>
</html>