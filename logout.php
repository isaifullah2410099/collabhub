<?php
session_start();

// Remove all login information from the session.
session_unset();
session_destroy();

header('Location: index.php');
exit();
?>
