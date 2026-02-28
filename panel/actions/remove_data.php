<?php
$filename = '../get-panel/info-panel.txt';

if (file_exists($filename)) {
    // Truncate the file to remove data
    $file = fopen($filename, 'w');

    fclose($file);
} 
?>
