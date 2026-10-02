<?php
include 'admin_check.php';
include 'db.php';

$project_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if($project_id > 0){
    // Delete applications first, then delete the project.
    $conn->query("DELETE FROM applications WHERE project_id=$project_id");
    $conn->query("DELETE FROM projects WHERE project_id=$project_id");
}

header('Location: admin_projects.php?deleted=1');
exit();
?>
