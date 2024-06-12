<?php
include '../../app/database/connect.php';
include "../../path.php";
session_start();

// Проверка авторизации
// SQL-запрос для выборки загруженных файлов
$sql_select_files = "SELECT id, file_name, mime_type, file_size, created_at FROM filess";
$result_files = $conn->query($sql_select_files);

// Закрытие подключения
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
    <link rel="stylesheet" href="../../assets/css/style.css">
    <title>Файлы</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include"../../app/include/header.php"; ?>
<div class="container">
    <h1 class="mt-4">Загрузить файл</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <input type="file" name="uploaded_file" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Загрузить файл</button>
    </form>

    <h2 class="mt-4">Список лекций и полезных материалов</h2>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Имя файла</th>
            <th>Тип</th>
            <th>Размер</th>
            <th>Дата загрузки</th>
            <th>Действие</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $result_files->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['file_name']; ?></td>
                <td><?php echo $row['mime_type']; ?></td>
                <td><?php echo $row['file_size']; ?> байт</td>
                <td><?php echo $row['created_at']; ?></td>
                <td>
                    <a href="download.php?file_id=<?php echo $row['id']; ?>" class="btn btn-success">Скачать</a>
                </td>
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
