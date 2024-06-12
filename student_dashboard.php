<?php
include 'app/database/connect.php';
session_start();

if (!isset($_SESSION['student_id'])) {
    header("Location: log.php");
    exit;
}

$student_id = $_SESSION['student_id'];

// Обработка изменения пароля
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

    $sql = "SELECT password FROM students WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();

    if (password_verify($current_password, $hashed_password)) {
        $stmt->close();
        $sql = "UPDATE students SET password = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $new_password, $student_id);
        if ($stmt->execute()) {
            echo "Password changed successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Current password is incorrect.";
    }
    $stmt->close();
}

// Получение списка тестов
$tests_sql = "SELECT * FROM tests";
$tests_result = $conn->query($tests_sql);

// Получение списка лекций
$lectures_sql = "SELECT * FROM lectures";
$lectures_result = $conn->query($lectures_sql);

$conn->close();
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Custom Styling -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>My site</title>
</head>
<body>
<div class="container mt-4">
    <h1>Welcome to Your Dashboard</h1>
    <h2>Tests</h2>
    <ul class="list-group">
        <?php while ($test = $tests_result->fetch_assoc()) : ?>
            <li class="list-group-item">
                <a href="test.php?test_id=<?= $test['id'] ?>"><?= $test['name'] ?></a>
                <p><?= $test['description'] ?></p>
            </li>
        <?php endwhile; ?>
    </ul>

    <h2 class="mt-4">Lectures</h2>
    <ul class="list-group">
        <?php while ($lecture = $lectures_result->fetch_assoc()) : ?>
            <li class="list-group-item">
                <h5><?= $lecture['title'] ?></h5>
                <p><?= $lecture['content'] ?></p>
                <?php if ($lecture['file_path']) : ?>
                    <a href="<?= $lecture['file_path'] ?>" class="btn btn-primary" download>Download Lecture</a>
                <?php endif; ?>
            </li>
        <?php endwhile; ?>
    </ul>

    <h2 class="mt-4">Change Password</h2>
    <form action="student_dashboard.php" method="post">
        <div class="form-group">
            <label for="current_password">Current Password</label>
            <input type="password" class="form-control" id="current_password" name="current_password" required>
        </div>
        <div class="form-group">
            <label for="new_password">New Password</label>
            <input type="password" class="form-control" id="new_password" name="new_password" required>
        </div>
        <button type="submit" class="btn btn-primary" name="change_password">Change Password</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>