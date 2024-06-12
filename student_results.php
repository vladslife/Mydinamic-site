<?php
include 'app/database/connect.php';
session_start();
$conn = new mysqli('localhost', 'root', 'mysql', 'test_db');

$student_id = $_GET['student_id'];
$student = $conn->query("SELECT * FROM users WHERE id = $student_id")->fetch_assoc();
$student_results = $conn->query("
    SELECT t.test_name, r.score, r.date_taken
    FROM test_results r
    JOIN tests t ON r.test_id = t.id
    WHERE r.id = $student_id
    ORDER BY r.date_taken DESC
");

$all_results = $conn->query("
    SELECT s.username, s.email, t.test_name, r.score, r.date_taken
    FROM test_results r
    JOIN users s ON r.id = s.id
    JOIN tests t ON r.test_id = t.id
    ORDER BY r.date_taken DESC
");
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Результаты тестирования</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Результаты тестирования</h1>

    <h2>Результаты студента: <?php echo htmlspecialchars($student['username']); ?> (<?php echo htmlspecialchars($student['email']); ?>)</h2>
    <table>
        <thead>
        <tr>
            <th>Тест</th>
            <th>Результат</th>
            <th>Дата прохождения</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($result = $student_results->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($result['test_name']); ?></td>
                <td><?php echo htmlspecialchars($result['score']); ?></td>
                <td><?php echo htmlspecialchars($result['date_taken']); ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <h2>Результаты всех студентов</h2>
    <table>
        <thead>
        <tr>
            <th>Имя</th>
            <th>Email</th>
            <th>Тест</th>
            <th>Результат</th>
            <th>Дата прохождения</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($result = $all_results->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($result['username']); ?></td>
                <td><?php echo htmlspecialchars($result['email']); ?></td>
                <td><?php echo htmlspecialchars($result['test_name']); ?></td>
                <td><?php echo htmlspecialchars($result['score']); ?></td>
                <td><?php echo htmlspecialchars($result['date_taken']); ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>