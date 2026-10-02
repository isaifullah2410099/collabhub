<?php
session_start();
include 'db.php';

$message = '';

// Step 1: Find the student account.
if(isset($_POST['findBtn'])){
    $student_id = $conn->real_escape_string(trim($_POST['student_id']));
    $sql = "SELECT user_id, student_id, security_question FROM users WHERE student_id='$student_id'";
    $result = $conn->query($sql);

    if($result && $result->num_rows > 0){
        $row = $result->fetch_assoc();
        $_SESSION['reset_user_id'] = $row['user_id'];
        $_SESSION['reset_student_id'] = $row['student_id'];
        $_SESSION['security_question'] = $row['security_question'];
    }
    else{
        $message = 'Student ID was not found.';
    }
}

// Step 2: Check the security answer.
if(isset($_POST['answerBtn'])){
    $user_id = (int)$_SESSION['reset_user_id'];
    $answer = strtolower(trim($_POST['security_answer']));

    $sql = "SELECT security_answer FROM users WHERE user_id=$user_id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if(password_verify($answer, $row['security_answer'])){
        $_SESSION['answer_correct'] = true;
        header('Location: reset_password.php');
        exit();
    }
    else{
        $message = 'Security answer is incorrect.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - UIU CollabHub</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="auth-page">
<?php include 'public_navbar.php'; ?>

<main class="auth-layout">
    <section class="auth-intro">
        <p class="page-kicker">Password recovery</p>
        <h1>Recover your account.</h1>
        <p>Enter your Student ID first. The website will show the security question saved during registration.</p>
    </section>

    <section class="auth-box">
        <h2>Forgot Password</h2>
        <p class="subtitle">Complete the steps below to reset your password.</p>

        <?php if($message != ''){ ?>
            <p class="message error"><?= htmlspecialchars($message) ?></p>
        <?php } ?>

        <?php if(!isset($_SESSION['reset_user_id'])){ ?>
            <form method="post">
                <label>Enter Student ID</label>
                <input type="text" name="student_id" required>
                <button class="primary" type="submit" name="findBtn">Continue</button>
            </form>
        <?php } else { ?>
            <form method="post">
                <label>Security Question</label>
                <p class="question-box"><?= htmlspecialchars($_SESSION['security_question']) ?></p>

                <label>Your Answer</label>
                <input type="text" name="security_answer" required>
                <button class="primary" type="submit" name="answerBtn">Check Answer</button>
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
