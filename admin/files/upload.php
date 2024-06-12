<?php
include '../../app/database/connect.php';

session_start();

// Проверка авторизации
if (!isset($_SESSION['id'])) {
    header('location: ' . BASE_URL . 'log.php');
    exit();
}

// Проверка прав администратора (предполагаем, что у администратора есть роль 'admin')
if ($_SESSION['admin'] !== 1) {
    header('location: ' . BASE_URL . 'index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $fileName = basename($file['name']);
    $filePath = 'uploads/' . $fileName;

    // Создание директории для загрузки файлов, если она не существует
    if (!file_exists('uploads')) {
        mkdir('uploads', 0777, true);
    }

    // Перемещение загруженного файла в директорию uploads
    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        $stmt = $conn->prepare("INSERT INTO files (file_name, file_path) VALUES (?, ?)");
        $stmt->bind_param("ss", $fileName, $filePath);
        if ($stmt->execute()) {
            $message = "Файл успешно загружен.";
        } else {
            $message = "Ошибка при сохранении информации о файле в базе данных.";
        }
    } else {
        $message = "Ошибка при загрузке файла.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Загрузка файлов</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1 class="mt-4">Загрузка файлов</h1>
    <?php if (isset($message)): ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="file">Выберите файл для загрузки:</label>
            <input type="file" class="form-control-file" id="file" name="file" required>
        </div>
        <button type="submit" class="btn btn-primary">Загрузить файл</button>
    </form>
</div>
<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>