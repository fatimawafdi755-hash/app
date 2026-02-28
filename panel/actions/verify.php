<?php
if (isset($_POST['h-captcha-response'])) {
    $data = [
        'secret' => '0x6A02f88cbB249E280468c7f2840257968a57F147',
        'response' => $_POST['h-captcha-response']
    ];
    
    $verify = curl_init();
    curl_setopt($verify, CURLOPT_URL, 'https://hcaptcha.com/siteverify');
    curl_setopt($verify, CURLOPT_POST, true);
    curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($verify);
    $responseData = json_decode($response);

    if ($responseData->success) {
        echo "success";
    } else {
        echo "failure";
    }
}
?>
