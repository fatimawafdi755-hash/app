<?php
    $folder = '../storage/'; // path to your files folder
    $files = glob($folder . '/*.*'); // get all files
    echo json_encode(['count' => count($files)]);
?>