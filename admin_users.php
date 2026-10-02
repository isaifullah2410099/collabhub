<?php
include 'admin_check.php';
include 'db.php';

$result = $conn->query("SELECT * FROM users ORDER BY user_id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - UIU CollabHub</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'admin_navbar.php'; ?>

<main class="page-container">
    <header class="section-title">
        <div>
            <p class="page-kicker">Administration</p>
            <h1 class="page-heading">Manage users.</h1>
            <p class="page-copy">Edit student profile information or remove an account and its related data.</p>
        </div>
        <a class="button-link" href="admin_dashboard.php">Back to Dashboard</a>
    </header>

    <?php if(isset($_GET['deleted'])){ ?>
        <p class="message success">User removed successfully.</p>
    <?php } ?>

    <section class="table-card">
        <table>
            <tr>
                <th>ID</th>
                <th>Student ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Department</th>
                <th>Skills</th>
                <th>Action</th>
            </tr>
            <?php if($result && $result->num_rows > 0){ ?>
                <?php while($row = $result->fetch_assoc()){ ?>
                    <tr>
                        <td><?= $row['user_id'] ?></td>
                        <td><?= htmlspecialchars($row['student_id']) ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['department']) ?></td>
                        <td><?= htmlspecialchars($row['skills'] ?: '-') ?></td>
                        <td>
                            <a class="mini-action" href="admin_edit_user.php?id=<?= $row['user_id'] ?>">Edit</a>
                            <a class="mini-action reject" href="admin_delete_user.php?id=<?= $row['user_id'] ?>" onclick="return confirm('Delete this user and related data?')">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr><td colspan="7">No student accounts yet.</td></tr>
            <?php } ?>
        </table>
    </section>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
