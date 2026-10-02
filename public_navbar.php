<?php
// Navigation used before the user logs in.
$current_page = basename($_SERVER['PHP_SELF']);
?>
<header class="site-header">
    <div class="site-nav">
        <a class="brand" href="index.php">UIU <span>CollabHub</span></a>

        <nav class="nav-links">
            <a class="<?= $current_page == 'index.php' ? 'active' : '' ?>" href="index.php">Login</a>
            <a class="<?= $current_page == 'register.php' ? 'active' : '' ?>" href="register.php">Register</a>
        </nav>

        <div class="nav-actions">
            <a class="button-link primary" href="register.php">Get Started</a>
        </div>
    </div>
</header>
