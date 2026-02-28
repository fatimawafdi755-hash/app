<?php
error_reporting(0);
session_start();

include "../../setting/functions.php";
$ip = get_client_ip();
$jsonFilePath = "../admin/admin.json";
$json_data = file_get_contents($jsonFilePath);
$settings_data = json_decode($json_data, true);

if (isset($_POST['logout'])) {
    $settings_data['login_status'] = [];
    $updated_json_data = json_encode($settings_data);
    file_put_contents($jsonFilePath, $updated_json_data);
    
    echo 
    "<script>
        window.location.replace('../pages/login.php');
    </script>";
}
