<?php
include '../../app/database/connect.php';
session_start();

// Проверка авторизации
if (!isset($_SESSION['id'])) {
    header('location: ' . BASE_URL . 'log.php');
    exit();

}

$user_id = $_SESSION['id'];
$tests = $conn->query("SELECT * FROM test");
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
</head>
<body>
<div class="container">
    <h1 class="mt-4">Выберите тест для прохождения</h1>
    <div class="list-group">
        <?php while ($test = $tests->fetch_assoc()): ?>
            <a href="functions.php?test_id=<?php echo $test['id']; ?>" class="list-group-item list-group-item-action">
                <?php echo $test['test_name']; ?>
            </a>
        <?php endwhile; ?>
    </div>
</div>
<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>