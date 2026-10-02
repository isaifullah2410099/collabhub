<?php
include 'auth_check.php';
include 'db.php';

if(isset($_POST['applyBtn'])){
    $project_id = (int)$_POST['project_id'];
    $applicant_id = (int)$_SESSION['user_id'];
    $proposal = $conn->real_escape_string(trim($_POST['proposal']));

    // Make sure the user is not applying to their own project.
    $project_sql = "SELECT user_id, status FROM projects WHERE project_id=$project_id";
    $project_result = $conn->query($project_sql);

    if($project_result && $project_result->num_rows > 0){
        $project = $project_result->fetch_assoc();

        if($project['user_id'] != $applicant_id && $project['status'] == 'Open'){
            $sql = "INSERT INTO applications(project_id, applicant_id, proposal)
                    VALUES($project_id, $applicant_id, '$proposal')";
            $conn->query($sql);
        }
    }

    header("Location: project_details.php?id=$project_id");
    exit();
}

header('Location: projects.php');
exit();
?>
