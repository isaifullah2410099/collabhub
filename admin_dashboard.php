<?php
include 'admin_check.php';
include 'db.php';

// Count information for the admin dashboard.
$user_result = $conn->query("SELECT COUNT(*) AS total FROM users");
$total_users = $user_result->fetch_assoc()['total'];

$project_result = $conn->query("SELECT COUNT(*) AS total FROM projects");
$total_projects = $project_result->fetch_assoc()['total'];

$app_result = $conn->query("SELECT COUNT(*) AS total FROM applications");
$total_applications = $app_result->fetch_assoc()['total'];

$portfolio_result = $conn->query("SELECT COUNT(*) AS total FROM portfolio");
$total_portfolio = $portfolio_result->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - UIU CollabHub</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'admin_navbar.php'; ?>

<main class="page-container">
    <section class="admin-heading">
        <p class="page-kicker">Administration</p>
        <h1>Control the platform.</h1>
        <p class="page-copy">Manage student accounts, project posts and the data used in the class demonstration.</p>
    </section>

    <section class="dashboard-summary">
        <div class="dashboard-stat"><strong><?= $total_users ?></strong><span>Users</span></div>
        <div class="dashboard-stat"><strong><?= $total_projects ?></strong><span>Projects</span></div>
        <div class="dashboard-stat"><strong><?= $total_applications ?></strong><span>Applications</span></div>
    </section>

    <section class="admin-actions">
        <div class="admin-action-row">
            <div>
                <h2>Manage Users</h2>
                <p>View student accounts, edit profile information or remove an account.</p>
            </div>
            <a class="button-link primary" href="admin_users.php">Open User Manager</a>
        </div>

        <div class="admin-action-row">
            <div>
                <h2>Manage Projects</h2>
                <p>Edit or remove project posts, academic projects, research work and freelance gigs.</p>
            </div>
            <a class="button-link primary" href="admin_projects.php">Open Project Manager</a>
        </div>

        <div class="admin-action-row">
            <div>
                <h2>Portfolio Items</h2>
                <p>The database currently contains <?= $total_portfolio ?> portfolio item(s).</p>
            </div>
            <span class="status open">Database Info</span>
        </div>
    </section>

    <div class="demo-note">
        <strong>Demo login:</strong> username <code>admin</code> and password <code>1234</code>. This hard-coded login is only for the classroom project.
    </div>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
