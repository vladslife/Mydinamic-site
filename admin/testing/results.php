<?php
include '../../app/database/connect.php';
include "../../path.php";
session_start();

// Проверка авторизации
if (!isset($_SESSION['id'])) {
    header('location: ' . BASE_URL . 'log.php');
    exit();
}

$user_id = $_SESSION['id'];

$results = $conn->query("
    SELECT sr.id, sr.score, sr.date_taken, t.test_name, s.username as student_name
    FROM students_results sr
    JOIN test t ON sr.test_id = t.id
    JOIN students s ON sr.student_id = s.id
    ORDER BY sr.score DESC
");
?>

<!doctype html>
<html lang="ru">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Custom Styling -->
    <link rel="stylesheet" href="../../assets/css/admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:wght@500;700&display=swap" rel="stylesheet">
    <title>Результаты тестов</title>
    <style>
        /* Дополнительные стили для отступов */
        body {
            padding-top: 20px;
        }
        .mt-4 {
            margin-top: 40px;
        }
    </style>
</head>
<body>
<?php include("../../app/include/header.php"); ?>
<div class="container">
    <h1 class="mt-4">Результаты тестов</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
        <tr>
            <th>ID</th>
            <th>Студент</th>
            <th>Тест</th>
            <th>Результат</th>
            <th>Дата прохождения</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($result = $results->fetch_assoc()): ?>
            <tr>
                <td><?php echo $result['id']; ?></td>
                <td><?php echo htmlspecialchars($result['student_name']); ?></td>
                <td><?php echo htmlspecialchars($result['test_name']); ?></td>
                <td><?php echo $result['score']; ?></td>
                <td><?php echo $result['date_taken']; ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
        <div class="mb-4">
            <a href="<?php echo BASE_URL; ?>admin/testing/tests.php" class="btn btn-primary">Список тестов</a>
            <a href="<?php echo BASE_URL; ?>" class="btn btn-secondary">Главная страница</a>
        </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

