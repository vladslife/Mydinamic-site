<?php
$conn = new mysqli('localhost', 'root', 'mysql', 'test_db'); // Замените 'root' и '' на ваши учетные данные MySQL

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $test_id = $_POST['test_id'];

    $student = $conn->query("SELECT * FROM users WHERE email = '$email'")->fetch_assoc();
    if ($student) {
        $student_id = $student['id'];
        header("Location: test.php?student_id=$student_id&test_id=$test_id");
        exit();
    } else {
        echo "Студент с таким email не найден.";
    }
}

$tests = $conn->query("SELECT * FROM tests");
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация для студентов</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Регистрация для студентов</h1>
    <form method="post" action="register.php">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br>
        <label for="test_id">Тест:</label>
        <select name="test_id" id="test_id" required>
            <?php while ($test = $tests->fetch_assoc()): ?>
                <option value="<?php echo $test['id']; ?>"><?php echo $test['test_name']; ?></option>
            <?php endwhile; ?>
        </select><br>
        <input type="submit" value="Перейти к тесту">
    </form>
</div>
</body>
</html>