<?php
include 'auth_check.php';
include 'db.php';

if(isset($_POST['addBtn'])){
    $user_id = (int)$_SESSION['user_id'];
    $title = $conn->real_escape_string(trim($_POST['title']));
    $description = $conn->real_escape_string(trim($_POST['description']));
    $skills = $conn->real_escape_string(trim($_POST['skills']));

    $sql = "INSERT INTO portfolio(user_id, title, description, skills)
            VALUES($user_id, '$title', '$description', '$skills')";
    $conn->query($sql);

    header("Location: profile.php?id=$user_id");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Portfolio - UIU CollabHub</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>

<main class="page-container narrow-page">
    <header>
        <p class="page-kicker">Portfolio</p>
        <h1 class="page-heading">Add finished work.</h1>
        <p class="page-copy">Show a project you completed and the skills you used while working on it.</p>
    </header>

    <section class="form-card">
        <form method="post">
            <label>Project Title</label>
            <input type="text" name="title" required>

            <label>Description</label>
            <textarea name="description" rows="7" required></textarea>

            <label>Skills Used</label>
            <input type="text" name="skills" placeholder="PHP, MySQL, HTML">

            <div class="form-actions">
                <a class="button-link" href="profile.php?id=<?= $_SESSION['user_id'] ?>">Cancel</a>
                <button class="primary" type="submit" name="addBtn">Add to Portfolio</button>
            </div>
        </form>
    </section>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
