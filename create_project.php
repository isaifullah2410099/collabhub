<?php
include 'auth_check.php';
include 'db.php';

$message = '';

if(isset($_POST['postBtn'])){
    $user_id = (int)$_SESSION['user_id'];
    $title = $conn->real_escape_string(trim($_POST['title']));
    $project_type = $conn->real_escape_string($_POST['project_type']);
    $description = $conn->real_escape_string(trim($_POST['description']));
    $skills = $conn->real_escape_string(trim($_POST['skills_needed']));
    $team_size = (int)$_POST['team_size'];
    $deadline = $conn->real_escape_string($_POST['deadline']);

    $sql = "INSERT INTO projects(user_id, title, project_type, description, skills_needed, team_size, deadline)
            VALUES($user_id, '$title', '$project_type', '$description', '$skills', $team_size, '$deadline')";

    if($conn->query($sql) === TRUE){
        header('Location: dashboard.php?project=created');
        exit();
    }
    else{
        $message = 'Project could not be posted.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Project - UIU CollabHub</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>

<main class="page-container narrow-page">
    <header>
        <p class="page-kicker">New opportunity</p>
        <h1 class="page-heading">Post a project.</h1>
        <p class="page-copy">Tell other students what you are working on, what skills you need, and how many collaborators you are looking for.</p>
    </header>

    <section class="form-card">
        <?php if($message != ''){ ?>
            <p class="message error"><?= htmlspecialchars($message) ?></p>
        <?php } ?>

        <form method="post">
            <div class="form-grid">
                <div class="form-field full">
                    <label>Project Title</label>
                    <input type="text" name="title" placeholder="Example: UIU Lost & Found Platform" required>
                </div>

                <div class="form-field">
                    <label>Project Type</label>
                    <select name="project_type" required>
                        <option value="">Select Type</option>
                        <option>Personal Project</option>
                        <option>Research</option>
                        <option>Freelance Gig</option>
                        <option>Academic Project</option>
                        <option>Other</option>
                    </select>
                </div>

                <div class="form-field">
                    <label>Team Size</label>
                    <input type="number" name="team_size" min="1" max="20" placeholder="3" required>
                </div>

                <div class="form-field full">
                    <label>Description</label>
                    <textarea name="description" rows="7" placeholder="Explain the project and what kind of help you need." required></textarea>
                </div>

                <div class="form-field">
                    <label>Skills Needed</label>
                    <input type="text" name="skills_needed" placeholder="HTML, CSS, PHP, MySQL" required>
                </div>

                <div class="form-field">
                    <label>Deadline</label>
                    <input type="date" name="deadline" required>
                </div>
            </div>

            <div class="form-actions">
                <a class="button-link" href="dashboard.php">Cancel</a>
                <button class="primary" type="submit" name="postBtn">Post Project</button>
            </div>
        </form>
    </section>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
