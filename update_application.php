<?php
include 'auth_check.php';
include 'db.php';

$application_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$project_id = isset($_GET['project_id']) ? (int)$_GET['project_id'] : 0;
$status = isset($_GET['status']) ? $_GET['status'] : '';
$user_id = (int)$_SESSION['user_id'];

// Only Accepted or Rejected are allowed.
if($status != 'Accepted' && $status != 'Rejected'){
    $status = 'Pending';
}

// Check that this project belongs to the logged in user.
$check_sql = "SELECT project_id FROM projects WHERE project_id=$project_id AND user_id=$user_id";
$check_result = $conn->query($check_sql);

if($check_result && $check_result->num_rows > 0){
    $sql = "UPDATE applications SET status='$status'
            WHERE application_id=$application_id AND project_id=$project_id";
    $conn->query($sql);
}

header("Location: manage_applications.php?project_id=$project_id");
exit();
?>
