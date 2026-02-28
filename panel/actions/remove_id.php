<?php
session_start();

if (isset($_POST['remove_id'])) {
    $file_tagret = $_POST['remove_id'];
    $user_id = $_POST['user_id'];
    $file = "../storage/{$file_tagret}";

    if (file_exists($file)) {
        if (unlink($file)) {
            $filePath = '../get-panel/info-panel.txt';
            $originalWord =  $user_id;
            $replacementWord = "This ID Is Removed !?";
            $fileContent = file_get_contents($filePath);
            $modifiedContent = str_replace($originalWord, $replacementWord, $fileContent);
            file_put_contents($filePath, $modifiedContent);

            $_SESSION["message_panel"] = "This ID '$user_id' was successfully Removed.";

        } else {
            $_SESSION["message_panel"] = "Error Removed the ID.";
        }
    } else {
        $_SESSION["message_panel"] = "This ID ". $user_id ." Is Already Removed.";
    }
    
    header("Location: ../pages/main_panel.php");
    exit(); 
}
?>
