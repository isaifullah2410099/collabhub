<?php
include 'auth_check.php';
include 'db.php';

$project_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$user_id = (int)$_SESSION['user_id'];

$sql = "SELECT projects.*, users.name, users.department FROM projects
        JOIN users ON projects.user_id = users.user_id
        WHERE projects.project_id=$project_id";
$result = $conn->query($sql);

if(!$result || $result->num_rows == 0){
    die('Project not found.');
}

$project = $result->fetch_assoc();

// Check if the logged in student already applied.
$application = null;
$app_sql = "SELECT * FROM applications WHERE project_id=$project_id AND applicant_id=$user_id";
$app_result = $conn->query($app_sql);
if($app_result && $app_result->num_rows > 0){
    $application = $app_result->fetch_assoc();
}

// Get accepted team members.
$team_sql = "SELECT users.user_id, users.name, users.department FROM applications
             JOIN users ON applications.applicant_id = users.user_id
             WHERE applications.project_id=$project_id AND applications.status='Accepted'";
$team_result = $conn->query($team_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($project['title']) ?> - UIU CollabHub</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>

<main class="page-container">
    <a class="clear-link" href="projects.php">&larr; Back to Explore</a>

    <section class="project-title-block">
        <span class="project-type"><?= htmlspecialchars($project['project_type']) ?></span>
        <h1><?= htmlspecialchars($project['title']) ?></h1>
        <p class="page-copy">Posted by <a href="profile.php?id=<?= $project['user_id'] ?>"><strong><?= htmlspecialchars($project['name']) ?></strong></a> &middot; <?= htmlspecialchars($project['department']) ?></p>
    </section>

    <section class="project-facts">
        <div class="fact"><span>Owner</span><strong><?= htmlspecialchars($project['name']) ?></strong></div>
        <div class="fact"><span>Project Type</span><strong><?= htmlspecialchars($project['project_type']) ?></strong></div>
        <div class="fact"><span>Team Size</span><strong><?= (int)$project['team_size'] ?></strong></div>
        <div class="fact"><span>Deadline</span><strong><?= htmlspecialchars($project['deadline']) ?></strong></div>
        <div class="fact"><span>Status</span><strong><?= htmlspecialchars($project['status']) ?></strong></div>
    </section>

    <div class="details-layout">
        <div class="details-main">
            <section>
                <p class="page-kicker">About this project</p>
                <h2>Project brief</h2>
                <p class="long-text muted"><?= nl2br(htmlspecialchars($project['description'])) ?></p>
            </section>

            <section>
                <p class="page-kicker">Skills needed</p>
                <div class="project-tags">
                    <?php
                    $skills = explode(',', $project['skills_needed']);
                    foreach($skills as $skill){
                        $skill = trim($skill);
                        if($skill != ''){
                    ?>
                        <span><?= htmlspecialchars($skill) ?></span>
                    <?php
                        }
                    }
                    ?>
                </div>
            </section>

            <section>
                <p class="page-kicker">Team</p>
                <h2>Accepted members</h2>

                <?php if($team_result && $team_result->num_rows > 0){ ?>
                    <div class="dashboard-list">
                        <?php while($member = $team_result->fetch_assoc()){ ?>
                            <div class="list-item">
                                <div>
                                    <strong><a href="profile.php?id=<?= $member['user_id'] ?>"><?= htmlspecialchars($member['name']) ?></a></strong>
                                    <p class="muted"><?= htmlspecialchars($member['department']) ?></p>
                                </div>
                                <span class="status accepted">Accepted</span>
                            </div>
                        <?php } ?>
                    </div>
                <?php } else { ?>
                    <p class="muted">No members accepted yet.</p>
                <?php } ?>
            </section>
        </div>

        <aside class="details-side">
            <section>
                <?php if($project['user_id'] == $user_id){ ?>
                    <p class="page-kicker">Project owner</p>
                    <h3>This is your project.</h3>
                    <p class="muted">Open the applicant list to review proposals and form your team.</p>
                    <a class="button-link primary full" href="manage_applications.php?project_id=<?= $project_id ?>">Manage Applicants</a>
                <?php } else if($project['status'] != 'Open'){ ?>
                    <p class="page-kicker">Applications</p>
                    <h3>Applications are closed.</h3>
                    <p class="muted">This project is not accepting new proposals.</p>
                <?php } else if($application){ ?>
                    <p class="page-kicker">Your proposal</p>
                    <h3>Application status</h3>
                    <p><span class="status <?= strtolower($application['status']) ?>"><?= htmlspecialchars($application['status']) ?></span></p>
                    <p class="muted long-text"><?= nl2br(htmlspecialchars($application['proposal'])) ?></p>
                <?php } else { ?>
                    <p class="page-kicker">Join the project</p>
                    <h3>Send a proposal.</h3>
                    <form method="post" action="apply.php">
                        <input type="hidden" name="project_id" value="<?= $project_id ?>">
                        <label>Your Proposal</label>
                        <textarea name="proposal" rows="7" placeholder="Explain how you can help the project..." required></textarea>
                        <button class="primary" type="submit" name="applyBtn">Send Proposal</button>
                    </form>
                <?php } ?>
            </section>
        </aside>
    </div>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
