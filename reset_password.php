<?php
session_start();
include 'db.php';

// User can only reach this page after answering the security question.
if(!isset($_SESSION['answer_correct']) || $_SESSION['answer_correct'] != true){
    header('Location: forgot_password.php');
    exit();
}

$message = '';
$message_type = '';

if(isset($_POST['resetBtn'])){
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $user_id = (int)$_SESSION['reset_user_id'];

    if($password != $confirm_password){
        $message = 'Passwords do not match.';
        $message_type = 'error';
    }
    else if(strlen($password) < 6){
        $message = 'Password must be at least 6 characters.';
        $message_type = 'error';
    }
    else{
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password='$password_hash' WHERE user_id=$user_id";
        $conn->query($sql);

        // Clear password reset session values.
        unset($_SESSION['reset_user_id']);
        unset($_SESSION['reset_student_id']);
        unset($_SESSION['security_question']);
        unset($_SESSION['answer_correct']);

        $message = 'Password changed successfully. You can login now.';
        $message_type = 'success';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="auth-page">
<?php include 'public_navbar.php'; ?>

<main class="auth-layout">
    <section class="auth-intro">
        <p class="page-kicker">Final step</p>
        <h1>Choose a new password.</h1>
        <p>Use at least six characters. You can return to the login page after the password is changed.</p>
    </section>

    <section class="auth-box">
        <h2>Reset Password</h2>

        <?php if($message != ''){ ?>
            <p class="message <?= $message_type ?>"><?= htmlspecialchars($message) ?></p>
        <?php } ?>

        <?php if($message_type != 'success'){ ?>
        <form method="post">
            <label>New Password</label>
            <input type="password" name="password" required>

            <label>Confirm New Password</label>
            <input type="password" name="confirm_password" required>

            <button class="primary" type="submit" name="resetBtn">Reset Password</button>
        </form>
        <?php } ?>

        <div class="auth-links">
            <a href="index.php">Back to Login</a>
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
