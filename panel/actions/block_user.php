<?php
    error_reporting(0);
    session_start();

function validateIP($ip) {
    return filter_var($ip, FILTER_VALIDATE_IP) !== false;
}

if (isset($_POST['block_user'])) {
    $userIP = $_POST['block_user'];
    if (validateIP($userIP)) {
        $blockedIPs = file_get_contents('../actions/blocked_ips.txt');

        if (strpos($blockedIPs, $userIP) === false) {
            
            file_put_contents('blocked_ips.txt', $userIP . "\n", FILE_APPEND);
            $user_id = $_POST['user_id'];
            $filePath = '../get-panel/info-panel.txt';
            $originalWord =  $user_id . "," . "IN WEBSITE";
            $replacementWord = "This User Is Block !?". "," . "This User Is Block!?";
            $fileContent = file_get_contents($filePath);
            $modifiedContent = str_replace($originalWord, $replacementWord, $fileContent);
            file_put_contents($filePath, $modifiedContent);

            $statics_file = "../get-panel/statics.json";
            $statics_data = file_get_contents($statics_file);
            $user_data = json_decode($statics_data, true);
            $user_data['total_block'] += 1;
            $updated_statics_data = json_encode($user_data);
            file_put_contents($statics_file, $updated_statics_data);
            
            $_SESSION["message_panel"] = "This User Is Block - " . $userIP;
            header("Location: ../pages/main_panel.php");
            exit();
        } else {
            $userIP = $_POST['block_user'];
            $_SESSION["message_panel"] = "This User Is Already Block - " . $userIP;
            header("Location: ../pages/main_panel.php");
            exit();
        }
    } else {
        $userIP = $_POST['block_user'];
        $_SESSION["message_panel"] = "Invalid IP address - " . $userIP;
        header("Location: ../pages/main_panel.php");
        exit();
    }
}

?>
