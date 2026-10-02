<?php
// Shared student navigation.
$current_page = basename($_SERVER['PHP_SELF']);
?>
<header class="site-header">
    <div class="site-nav">
        <a class="brand" href="home.php">UIU <span>CollabHub</span></a>

        <nav class="nav-links">
            <a class="<?= $current_page == 'home.php' ? 'active' : '' ?>" href="home.php">Home</a>
            <a class="<?= in_array($current_page, ['projects.php', 'project_details.php']) ? 'active' : '' ?>" href="projects.php">Explore</a>
            <a class="<?= $current_page == 'dashboard.php' ? 'active' : '' ?>" href="dashboard.php">Dashboard</a>
            <a class="<?= in_array($current_page, ['profile.php', 'edit_profile.php', 'add_portfolio.php']) ? 'active' : '' ?>" href="profile.php?id=<?= $_SESSION['user_id'] ?>">Profile</a>
        </nav>

        <div class="nav-actions">
            <a class="button-link primary" href="create_project.php">Post Project</a>
            <a class="logout-link" href="logout.php">Logout</a>
        </div>
    </div>
</header>
