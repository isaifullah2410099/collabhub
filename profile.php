<?php
include 'auth_check.php';
include 'db.php';

$profile_id = isset($_GET['id']) ? (int)$_GET['id'] : (int)$_SESSION['user_id'];

$user_result = $conn->query("SELECT * FROM users WHERE user_id=$profile_id");
if(!$user_result || $user_result->num_rows == 0){
    die('User not found.');
}
$user = $user_result->fetch_assoc();

$portfolio_result = $conn->query("SELECT * FROM portfolio WHERE user_id=$profile_id ORDER BY portfolio_id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($user['name']) ?> - Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>

<main class="page-container">
    <p class="page-kicker">Student profile</p>

    <section class="profile-header">
        <div class="avatar-large"><?= htmlspecialchars(strtoupper(substr($user['name'], 0, 1))) ?></div>

        <div>
            <h1><?= htmlspecialchars($user['name']) ?></h1>
            <p><?= htmlspecialchars($user['department']) ?> &middot; United International University</p>
            <p>Student ID: <?= htmlspecialchars($user['student_id']) ?> &middot; <?= htmlspecialchars($user['email']) ?></p>
        </div>

        <?php if($profile_id == $_SESSION['user_id']){ ?>
            <a class="button-link primary" href="edit_profile.php">Edit Profile</a>
        <?php } ?>
    </section>

    <div class="profile-content">
        <div>
            <section class="profile-section">
                <h2>About</h2>
                <p class="long-text muted"><?= nl2br(htmlspecialchars($user['bio'] ?: 'No bio added yet.')) ?></p>
            </section>

            <section class="profile-section">
                <h3>Skills</h3>
                <?php if(trim($user['skills'] ?: '') != ''){ ?>
                    <div class="project-tags">
                        <?php
                        $skills = explode(',', $user['skills']);
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
                <?php } else { ?>
                    <p class="muted">No skills added yet.</p>
                <?php } ?>
            </section>
        </div>

        <section>
            <div class="section-title">
                <h2>Portfolio</h2>
                <?php if($profile_id == $_SESSION['user_id']){ ?>
                    <a class="button-link" href="add_portfolio.php">+ Add Item</a>
                <?php } ?>
            </div>

            <?php if($portfolio_result && $portfolio_result->num_rows > 0){ ?>
                <div class="portfolio-list">
                    <?php while($item = $portfolio_result->fetch_assoc()){ ?>
                        <article class="portfolio-item">
                            <h3><?= htmlspecialchars($item['title']) ?></h3>
                            <p><?= nl2br(htmlspecialchars($item['description'])) ?></p>

                            <?php if(trim($item['skills'] ?: '') != ''){ ?>
                                <div class="project-tags">
                                    <?php
                                    $item_skills = explode(',', $item['skills']);
                                    foreach($item_skills as $skill){
                                        $skill = trim($skill);
                                        if($skill != ''){
                                    ?>
                                        <span><?= htmlspecialchars($skill) ?></span>
                                    <?php
                                        }
                                    }
                                    ?>
                                </div>
                            <?php } ?>

                            <?php if($profile_id == $_SESSION['user_id']){ ?>
                                <p><a class="danger-link" href="delete_portfolio.php?id=<?= $item['portfolio_id'] ?>" onclick="return confirm('Delete this portfolio item?')">Delete item</a></p>
                            <?php } ?>
                        </article>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <div class="empty-box">No portfolio items added yet.</div>
            <?php } ?>
        </section>
    </div>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
