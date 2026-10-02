<?php
session_start();
include 'db.php';

$message = '';

// Run this code when the login button is pressed.
if(isset($_POST['loginBtn'])){
    $username = $conn->real_escape_string(trim($_POST['username']));
    $password = $_POST['password'];

    // Simple admin login requested for this class project.
    if($username == 'admin' && $password == '1234'){
        $_SESSION['role'] = 'admin';
        $_SESSION['admin_name'] = 'Admin';
        header('Location: admin_dashboard.php');
        exit();
    }

    // If it is not admin, check the student ID from the database.
    $sql = "SELECT * FROM users WHERE student_id='$username'";
    $result = $conn->query($sql);

    if($result && $result->num_rows > 0){
        $row = $result->fetch_assoc();

        // Check the password saved during registration.
        if(password_verify($password, $row['password'])){
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['student_id'] = $row['student_id'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['role'] = 'student';
            header('Location: home.php');
            exit();
        }
    }

    $message = 'Incorrect Student ID / Username or password.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - UIU CollabHub</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="auth-page">
<?php include 'public_navbar.php'; ?>

<main class="auth-layout">
    <section class="auth-intro">
        <p class="page-kicker">Student collaboration at UIU</p>
        <h1>Find people worth building with.</h1>
        <p>Post projects, find collaborators, send proposals, form teams and turn completed work into your portfolio.</p>
    </section>

    <section class="auth-box">
        <h2>Welcome back.</h2>
        <p class="subtitle">Login with your Student ID and password.</p>

        <?php if($message != ''){ ?>
            <p class="message error"><?= htmlspecialchars($message) ?></p>
        <?php } ?>

        <form method="post" action="index.php">
            <label>Student ID / Username</label>
            <input type="text" name="username" placeholder="011XXXXXXXX" required>

            <label>Password</label>
            <input type="password" name="password" placeholder="Enter password" required>

            <button class="primary" type="submit" name="loginBtn">Login</button>
        </form>

        <div class="auth-links">
            <a href="forgot_password.php">Forgot Password?</a>
            <span>New student? <a href="register.php">Register</a></span>
        </div>

        <div class="demo-note">
            <strong>Class demo admin:</strong> username <code>admin</code>, password <code>1234</code>.
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
