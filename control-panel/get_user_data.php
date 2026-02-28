<?php
if (isset($_GET['id_user'])) {
    $target = $_GET['id_user'];
    $file_name = $target;
    $jsonFilePath = "../panel/storage/{$file_name}.json";

    if (file_exists($jsonFilePath)) {
        $json_data = file_get_contents($jsonFilePath);
        $user_data = json_decode($json_data, true);
        echo json_encode($user_data['data']);
    } else {
        echo json_encode(['error' => 'ID IS Removed.']);
    }
} else {
    echo json_encode(['error' => 'User ID not provided.']);
}
