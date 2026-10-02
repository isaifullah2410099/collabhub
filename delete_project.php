<?php
include 'auth_check.php';
include 'db.php';

$project_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$user_id = (int)$_SESSION['user_id'];

// Check ownership before deleting anything.
$check = $conn->query("SELECT project_id FROM projects WHERE project_id=$project_id AND user_id=$user_id");

if($check && $check->num_rows > 0){
    // Remove related proposals first.
    $conn->query("DELETE FROM applications WHERE project_id=$project_id");

    // Then remove the project itself.
    $conn->query("DELETE FROM projects WHERE project_id=$project_id AND user_id=$user_id");
}

header('Location: dashboard.php');
exit();
?>
