<?php 
    error_reporting(0);
    session_start();
    include "../../setting/functions.php";
    include "../../setting/alert-admin.php";
    include "../../setting/config.php";
    include "../../libraries/UserInfo.php";

    $jsonFilePath = "../admin/admin.json";
    $json_data = file_get_contents($jsonFilePath);
    $user_data = json_decode($json_data, true);
    $login_status = $user_data['login_status'];
    $ip = get_client_ip();

    $ip_found = false;
    foreach ($user_data['login_status'] ?? [] as $login) {
        if ($login['ip'] === $ip) {
            $ip_found = true;
            break;
        }
    }
    
    if ($ip_found) {
        echo 
        "<script>
            window.location.replace('./main_panel.php');
        </script>";
        exit;
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- SEO -->
    <?php include '../../libraries/seo.php'; ?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/panel.css">
    <!-- Font Awesome Library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Favicon -->
    <link rel="icon" href="../img/favicon.png">
    <link rel="shortcut" href="../img/favicon.png">
    <link rel="appel-touch-icon" href="../img/favicon.png">
    <title>Admin Panel - Login</title>
</head>
<body>
    <!-- Start Login -->
    <div class="login">
        <div class="container">
            <div class="content-login">
                <form action="../admin/checking.php" method="post" id="formLogin">
                    <div class="parent-icon-and-title">
                        <img src="../img/favicon.png" alt="">
                        <h3 class="titles">Admin Panel - Login</h3> 
                    </div>
                    <!-- Start Mode Site -->
                    <?php 
                        if (isset($_SESSION["message_login"])) {
                            echo "<div class='message-panel'>" .  $_SESSION["message_login"] . "</div>";
                            unset($_SESSION["message_login"]);
                        }

                    ?>
                    <!-- Start Mode Site -->
                    <div class="parent-input" id="div1">
                        <label for="userName">Username</label>
                        <input type="text" name="username" placeholder="" id="userName">
                        <span class="icon-login-solid"><i class="fa-solid fa-user"></i></span>
                        <small id="messageError1" class="message-error">Please Enter A valid Username!</small>
                    </div>
                    <div class="parent-input" id="div2">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password">
                        <span class="icon-login-solid"><i class="fa-solid fa-lock"></i></span>
                        <small id="messageError2" class="message-error">Please Enter A valid Password!</small>
                    </div>
                    <button type="submit" name="button_login" id="buttonLogin" class="button-send-data">Sign In</button>
                </form>
            </div>
        </div>
    </div>
    <!-- End Login -->

    <!-- Script JS -->
     <script src="../js/login.js"></script>
</body>
</html>