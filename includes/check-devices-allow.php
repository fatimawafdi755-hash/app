<?php
$db_admin = "../panel/admin/admin.json";
$admin_data = file_get_contents($db_admin);
$settings_data = json_decode($admin_data, true);
$devices_mode = $settings_data['devices_mode'];

if ($devices_mode === "desktop") {
    function isDesktop() {
        // Define desktop operating systems
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
    
        // Get the user agent
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
    
        // Check if any desktop agent is found in the user-agent string
        foreach ($desktop_agents as $desktop) {
            if (strpos($user_agent, $desktop) !== false) {
                return true;
            }
        }
    
        return false;
    }
    // If it's not a desktop device, redirect
    if (!isDesktop()) {
        header("Location: https://www.superhonda.com/");
        exit();
    }
    
}
elseif ($devices_mode === "mobile") {
    function isMobileOrTablet() {
        // Updated regex pattern to match most mobile and tablet devices, including many brands and models
        return preg_match("/(android|webOS|iphone|ipad|ipod|blackberry|iemobile|opera mini|mobile|tablet|nokia|windows phone|kindle|silk|playbook|xoom|sm-t|gt-p|sony|motorola|lg|htc|samsung|nexus|surface|firefox os|tab|ipad mini|ipad air|ipad pro|galaxy|huawei|xiaomi|oppo|sony|asus|lenovo|htc|alcatel|zte|miui|poco|realme|oneplus|vivo|lava|karbonn|lava|micromax|meizu|infinix|tecno|sharp|panasonic|samsung|wiko|intex|gionee|umidigi|bq|doogee|cubot|ulefone|leeco|smartphone|tablet|phablet|xiaomi|gpad|lg pad|tcl|sony tablet)/i", $_SERVER['HTTP_USER_AGENT']);
    }
    
    if (!isMobileOrTablet()) {
        header("Location: https://www.superhonda.com/");
        exit();
    }
    
    
}

?>