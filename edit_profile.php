<?php
include 'auth_check.php';
include 'db.php';

$user_id = (int)$_SESSION['user_id'];
$message = '';

if(isset($_POST['saveBtn'])){
    $name = $conn->real_escape_string(trim($_POST['name']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $department = $conn->real_escape_string(trim($_POST['department']));
    $skills = $conn->real_escape_string(trim($_POST['skills']));
    $bio = $conn->real_escape_string(trim($_POST['bio']));

    $sql = "UPDATE users SET name='$name', email='$email', department='$department', skills='$skills', bio='$bio'
            WHERE user_id=$user_id";

    if($conn->query($sql) === TRUE){
        $_SESSION['name'] = $name;
        $message = 'Profile updated successfully.';
    }
}

$result = $conn->query("SELECT * FROM users WHERE user_id=$user_id");
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - UIU CollabHub</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>

<main class="page-container narrow-page">
    <header>
        <p class="page-kicker">Profile settings</p>
        <h1 class="page-heading">Edit your profile.</h1>
        <p class="page-copy">Keep your skills and bio updated so project owners can understand what you can contribute.</p>
    </header>

    <section class="form-card">
        <?php if($message != ''){ ?><p class="message success"><?= htmlspecialchars($message) ?></p><?php } ?>

        <form method="post">
            <div class="form-grid">
                <div class="form-field full">
                    <label>Student ID</label>
                    <input type="text" value="<?= htmlspecialchars($user['student_id']) ?>" disabled>
                </div>

                <div class="form-field">
                    <label>Name</label>
                    <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
                </div>

                <div class="form-field">
                    <label>Email</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                </div>

                <div class="form-field full">
                    <label>Department</label>
                    <input type="text" name="department" value="<?= htmlspecialchars($user['department']) ?>" required>
                </div>

                <div class="form-field full">
                    <label>Skills</label>
                    <input type="text" name="skills" value="<?= htmlspecialchars($user['skills']) ?>" placeholder="HTML, CSS, PHP, MySQL">
                </div>

                <div class="form-field full">
                    <label>Bio</label>
                    <textarea name="bio" rows="7" placeholder="Tell other students about yourself..."><?= htmlspecialchars($user['bio']) ?></textarea>
                </div>
            </div>

            <div class="form-actions">
                <a class="button-link" href="profile.php?id=<?= $user_id ?>">Cancel</a>
                <button class="primary" type="submit" name="saveBtn">Save Changes</button>
            </div>
        </form>
    </section>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
