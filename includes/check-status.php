<?php
session_start();
error_reporting(0);
include '../setting/functions.php';
$ip = get_client_ip();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userStatus = $_POST['userStatus'];
    $id_user = $_POST['id_user'];
    $user_ip = $ip;
    $name_file = $user_ip;
    $jsonFilePath = "../panel/storage/{$name_file}.json";

    if (file_exists($jsonFilePath)) {
        $jsonData = file_get_contents($jsonFilePath);
        $data = json_decode($jsonData, true);
    } else {
        file_put_contents('error_log.txt', 'User file does not exist.' . PHP_EOL, FILE_APPEND);
        echo 'User file does not exist.';
        exit;
    }

    $data['userStatus'] = $userStatus;

    $newJsonData = json_encode($data, JSON_PRETTY_PRINT);
    if (file_put_contents($jsonFilePath, $newJsonData) === false) {
        file_put_contents('error_log.txt', 'Failed to write to file.' . PHP_EOL, FILE_APPEND);
        echo 'Failed to write to file.';
    } else {
        echo 'User status updated successfully';
    }
}
?>