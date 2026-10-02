<?php
include 'auth_check.php';
include 'db.php';

// Show the newest open projects on the home page.
$sql = "SELECT projects.*, users.name FROM projects
        JOIN users ON projects.user_id = users.user_id
        WHERE projects.status='Open'
        ORDER BY projects.project_id DESC LIMIT 6";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - UIU CollabHub</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>

<main class="page-container">
    <section class="home-hero">
        <div>
            <p class="page-kicker">Welcome, <?= htmlspecialchars($_SESSION['name']) ?></p>
            <h1>Find people worth building with.</h1>
        </div>

        <div class="hero-side">
            <p>Search by skill, idea, or interest. Discover student projects that need collaborators and turn your work into a portfolio.</p>
            <div class="hero-actions">
                <a class="button-link primary" href="projects.php">Explore Projects</a>
                <a class="button-link" href="dashboard.php">Your Dashboard</a>
            </div>
        </div>
    </section>

    <section class="search-section">
        <div class="search-title-row">
            <h2>What do you want to work on?</h2>
            <span>Search projects, skills, or interests</span>
        </div>

        <form class="search-row" method="get" action="projects.php">
            <input type="text" name="search" placeholder='Try "PHP", "research", "UI design", "campus app"...'>
            <button class="primary" type="submit">Search</button>
        </form>

        <div class="skill-pills">
            <a class="skill-pill active" href="projects.php">Popular</a>
            <a class="skill-pill" href="projects.php?search=PHP">PHP</a>
            <a class="skill-pill" href="projects.php?search=MySQL">MySQL</a>
            <a class="skill-pill" href="projects.php?search=Research">Research</a>
            <a class="skill-pill" href="projects.php?search=Design">UI Design</a>
            <a class="skill-pill" href="projects.php?search=JavaScript">JavaScript</a>
        </div>
    </section>

    <section class="projects-section">
        <div class="projects-head">
            <h2>Recent opportunities</h2>
            <a href="projects.php">View all projects &rarr;</a>
        </div>

        <?php if($result && $result->num_rows > 0){ ?>
            <div class="project-timeline">
                <?php while($row = $result->fetch_assoc()){ ?>
                    <a class="project-row" href="project_details.php?id=<?= $row['project_id'] ?>">
                        <span class="project-dot"></span>

                        <div class="project-row-inner">
                            <div>
                                <span class="project-type"><?= htmlspecialchars($row['project_type']) ?></span>
                                <h3><?= htmlspecialchars($row['title']) ?></h3>
                                <p class="project-description"><?= htmlspecialchars(substr($row['description'], 0, 170)) ?><?= strlen($row['description']) > 170 ? '...' : '' ?></p>

                                <div class="project-tags">
                                    <?php
                                    $skills = explode(',', $row['skills_needed']);
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
                            </div>

                            <div class="project-meta">
                                <div class="project-meta-box">
                                    <strong><?= htmlspecialchars($row['name']) ?></strong>
                                    <?= (int)$row['team_size'] ?> team size<br>
                                    Deadline &middot; <?= htmlspecialchars($row['deadline']) ?>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php } ?>
            </div>
        <?php } else { ?>
            <div class="empty-box">
                No projects have been posted yet. <a href="create_project.php">Post the first project.</a>
            </div>
        <?php } ?>
    </section>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
