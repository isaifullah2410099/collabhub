<?php
// Shared admin navigation.
$current_page = basename($_SERVER['PHP_SELF']);
?>
<header class="site-header">
    <div class="site-nav">
        <a class="brand" href="admin_dashboard.php">UIU <span>CollabHub</span><span class="admin-badge">Admin</span></a>

        <nav class="nav-links">
            <a class="<?= $current_page == 'admin_dashboard.php' ? 'active' : '' ?>" href="admin_dashboard.php">Dashboard</a>
            <a class="<?= in_array($current_page, ['admin_users.php', 'admin_edit_user.php']) ? 'active' : '' ?>" href="admin_users.php">Users</a>
            <a class="<?= in_array($current_page, ['admin_projects.php', 'admin_edit_project.php']) ? 'active' : '' ?>" href="admin_projects.php">Projects</a>
        </nav>

        <div class="nav-actions">
            <a class="logout-link" href="logout.php">Logout</a>
        </div>
    </div>
</header>
