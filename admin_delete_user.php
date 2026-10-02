<?php
include 'admin_check.php';
include 'db.php';

$user_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if($user_id > 0){
    // First remove applications for projects owned by this user.
    $project_result = $conn->query("SELECT project_id FROM projects WHERE user_id=$user_id");
    if($project_result){
        while($project = $project_result->fetch_assoc()){
            $project_id = (int)$project['project_id'];
            $conn->query("DELETE FROM applications WHERE project_id=$project_id");
        }
    }

    // Remove applications sent by this user.
    $conn->query("DELETE FROM applications WHERE applicant_id=$user_id");

    // Remove portfolio items and projects.
    $conn->query("DELETE FROM portfolio WHERE user_id=$user_id");
    $conn->query("DELETE FROM projects WHERE user_id=$user_id");

    // Finally remove the user account.
    $conn->query("DELETE FROM users WHERE user_id=$user_id");
}

header('Location: admin_users.php?deleted=1');
exit();
?>
