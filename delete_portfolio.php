<?php
include 'auth_check.php';
include 'db.php';

$portfolio_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$user_id = (int)$_SESSION['user_id'];

// The WHERE user_id condition stops a user from deleting another user's item.
$conn->query("DELETE FROM portfolio WHERE portfolio_id=$portfolio_id AND user_id=$user_id");

header("Location: profile.php?id=$user_id");
exit();
?>
