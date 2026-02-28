<?php

$jsonFilePath = "./admin.json";

if (basename($_SERVER['SCRIPT_FILENAME']) === basename(__FILE__)) {
    header("HTTP/1.0 403 Forbidden");
    exit('Access forbidden');
}

header('Content-Type: application/json');
readfile($jsonFilePath);

echo 
"<script>
    window.location = '../login.php';
</script>";

?>