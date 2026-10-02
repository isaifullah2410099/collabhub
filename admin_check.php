<?php
// Start the session if it has not started yet.
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

// Only the admin can open admin pages.
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header('Location: index.php');
    exit();
}
?>
