<?php
include 'auth_check.php';
include 'db.php';

$search = '';
$type = '';

// Optional simple search and type filter.
if(isset($_GET['search'])){
    $search = $conn->real_escape_string(trim($_GET['search']));
}
if(isset($_GET['type'])){
    $type = $conn->real_escape_string(trim($_GET['type']));
}

$sql = "SELECT projects.*, users.name FROM projects
        JOIN users ON projects.user_id = users.user_id WHERE 1=1";

if($search != ''){
    $sql .= " AND (projects.title LIKE '%$search%' OR projects.skills_needed LIKE '%$search%' OR projects.description LIKE '%$search%')";
}
if($type != ''){
    $sql .= " AND projects.project_type='$type'";
}

$sql .= " ORDER BY projects.project_id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Projects - UIU CollabHub</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>

<main class="page-container">
    <header>
        <p class="page-kicker">Opportunities</p>
        <h1 class="page-heading">Explore projects.</h1>
        <p class="page-copy">Search by skill, idea, project type, or interest. Open a project to see the full details and send a proposal.</p>
    </header>

    <section class="search-section">
        <form class="filter-form with-type" method="get">
            <input type="text" name="search" placeholder="Search title, description or skill" value="<?= htmlspecialchars($search) ?>">

            <select name="type">
                <option value="">All Types</option>
                <option <?= $type == 'Personal Project' ? 'selected' : '' ?>>Personal Project</option>
                <option <?= $type == 'Research' ? 'selected' : '' ?>>Research</option>
                <option <?= $type == 'Freelance Gig' ? 'selected' : '' ?>>Freelance Gig</option>
                <option <?= $type == 'Academic Project' ? 'selected' : '' ?>>Academic Project</option>
                <option <?= $type == 'Other' ? 'selected' : '' ?>>Other</option>
            </select>

            <button class="primary" type="submit">Search</button>
            <a class="clear-link" href="projects.php">Clear</a>
        </form>

        <div class="skill-pills">
            <a class="skill-pill <?= $search == '' ? 'active' : '' ?>" href="projects.php">All</a>
            <a class="skill-pill <?= strtolower($search) == 'php' ? 'active' : '' ?>" href="projects.php?search=PHP">PHP</a>
            <a class="skill-pill <?= strtolower($search) == 'mysql' ? 'active' : '' ?>" href="projects.php?search=MySQL">MySQL</a>
            <a class="skill-pill <?= strtolower($search) == 'research' ? 'active' : '' ?>" href="projects.php?search=Research">Research</a>
            <a class="skill-pill <?= strtolower($search) == 'design' ? 'active' : '' ?>" href="projects.php?search=Design">Design</a>
            <a class="skill-pill <?= strtolower($search) == 'javascript' ? 'active' : '' ?>" href="projects.php?search=JavaScript">JavaScript</a>
        </div>
    </section>

    <section class="projects-section">
        <div class="projects-head">
            <h2>Open opportunities</h2>
            <a href="create_project.php">Post your own project &rarr;</a>
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
                                <p class="project-description"><?= htmlspecialchars(substr($row['description'], 0, 190)) ?><?= strlen($row['description']) > 190 ? '...' : '' ?></p>

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
                                    <span><?= htmlspecialchars($row['status']) ?></span>
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
            <div class="empty-box">No projects matched your search.</div>
        <?php } ?>
    </section>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
