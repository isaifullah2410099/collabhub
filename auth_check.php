<?php
// Start a session so the website remembers the logged in user.
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

// Regular pages are only for logged in students.
if(!isset($_SESSION['user_id'])){
    header('Location: index.php');
    exit();
}
?>
