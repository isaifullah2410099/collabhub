<?php
include 'admin_check.php';
include 'db.php';

$project_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$message = '';

if(isset($_POST['saveBtn'])){
    $title = $conn->real_escape_string(trim($_POST['title']));
    $project_type = $conn->real_escape_string($_POST['project_type']);
    $description = $conn->real_escape_string(trim($_POST['description']));
    $skills = $conn->real_escape_string(trim($_POST['skills_needed']));
    $team_size = (int)$_POST['team_size'];
    $deadline = $conn->real_escape_string($_POST['deadline']);
    $status = $conn->real_escape_string($_POST['status']);

    $sql = "UPDATE projects SET title='$title', project_type='$project_type', description='$description',
            skills_needed='$skills', team_size=$team_size, deadline='$deadline', status='$status'
            WHERE project_id=$project_id";
    $conn->query($sql);
    $message = 'Project updated successfully.';
}

$result = $conn->query("SELECT * FROM projects WHERE project_id=$project_id");
if(!$result || $result->num_rows == 0){
    die('Project not found.');
}
$project = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Project - UIU CollabHub Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'admin_navbar.php'; ?>

<main class="page-container narrow-page">
    <header>
        <p class="page-kicker">Administration</p>
        <h1 class="page-heading">Edit project.</h1>
        <p class="page-copy">Change the project information shown to students.</p>
    </header>

    <section class="form-card">
        <?php if($message != ''){ ?><p class="message success"><?= htmlspecialchars($message) ?></p><?php } ?>

        <form method="post">
            <div class="form-grid">
                <div class="form-field full">
                    <label>Title</label>
                    <input type="text" name="title" value="<?= htmlspecialchars($project['title']) ?>" required>
                </div>

                <div class="form-field">
                    <label>Project Type</label>
                    <select name="project_type" required>
                        <?php
                        $types = ['Personal Project', 'Research', 'Freelance Gig', 'Academic Project', 'Other'];
                        foreach($types as $type){
                            $selected = $project['project_type'] == $type ? 'selected' : '';
                            echo "<option $selected>$type</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-field">
                    <label>Status</label>
                    <select name="status">
                        <option <?= $project['status'] == 'Open' ? 'selected' : '' ?>>Open</option>
                        <option <?= $project['status'] == 'Closed' ? 'selected' : '' ?>>Closed</option>
                    </select>
                </div>

                <div class="form-field full">
                    <label>Description</label>
                    <textarea name="description" rows="7" required><?= htmlspecialchars($project['description']) ?></textarea>
                </div>

                <div class="form-field">
                    <label>Skills Needed</label>
                    <input type="text" name="skills_needed" value="<?= htmlspecialchars($project['skills_needed']) ?>" required>
                </div>

                <div class="form-field">
                    <label>Team Size</label>
                    <input type="number" name="team_size" min="1" value="<?= $project['team_size'] ?>" required>
                </div>

                <div class="form-field full">
                    <label>Deadline</label>
                    <input type="date" name="deadline" value="<?= htmlspecialchars($project['deadline']) ?>" required>
                </div>
            </div>

            <div class="form-actions">
                <a class="button-link" href="admin_projects.php">Back</a>
                <button class="primary" type="submit" name="saveBtn">Save Changes</button>
            </div>
        </form>
    </section>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
