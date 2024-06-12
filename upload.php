<?php
include 'app/database/connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $target_dir = "uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $fileSize = $_FILES["file"]["size"];
    $fileContent = file_get_contents($_FILES["file"]["tmp_name"]);

    // Проверка на существование файла
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Проверка размера файла
    if ($fileSize > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Разрешенные форматы файлов
    $allowedTypes = ["jpg", "png", "jpeg", "gif", "pdf", "doc", "docx"];
    if (!in_array($fileType, $allowedTypes)) {
        echo "Sorry, only JPG, JPEG, PNG, GIF, PDF, DOC & DOCX files are allowed.";
        $uploadOk = 0;
    }

    // Проверка $uploadOk
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            $filename = basename($_FILES["file"]["name"]);
            $file_type = $target_file;

            $stmt = $conn->prepare("INSERT INTO files (file_name, file_type, file_size, file_content) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssis", $filename, $file_type, $fileSize, $fileContent);

            if ($stmt->execute()) {
                echo "The file ". htmlspecialchars($filename) . " has been uploaded.";
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Лекционные материалы</title>
    <link rel="stylesheet" href="./css/main.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .centered-container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            margin-top: 50px;
        }
        .content {
            width: 100%;
            max-width: 600px;
        }
        .file-list {
            list-style-type: none;
            padding: 0;
        }
        .file-list li {
            margin: 10px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .file-list a {
            margin-right: 20px;
        }
        .delete-button {
            background-color: #ff4d4d;
            border: none;
            color: white;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            cursor: pointer;
            border-radius: 5px;
        }
        .delete-button:hover {
            background-color: #ff1a1a;
        }
        .btn-danger {
            display: flex;
            align-items: center;
            justify-content: center;
        }

    </style>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="nav">
    <div class="container">
        <div class="nav-row">
            <a href="./index.php" class="logo"></a>
            <ul class="nav-list">

                <li class="nav-list__item"><a href="./studentLk.php" class="nav-list__link">Личный кабинет</a></li>
                <li class="nav-list__item"><a href="./lec.php" class="nav-list__link">Лекции</a></li>
                <li class="nav-list__item"><a href="./logout.php" class="nav-list__link">Выход</a></li>

            </ul>
        </div>
    </div>

</nav>

<div class="container centered-container">
    <div class="content">
        <h1 class="mb-4 text-center">Список лекций и файлов доступных для скачивания</h1>
        <ul class="list-group mb-4">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="uploads/Лекции по предмету Информатика.pptx" download>Лекции по предмету Информатика.pptx</a>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="uploads/Учебное пособие по Информатике.pdf" download>Учебное пособие по Информатике.pdf</a>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="uploads/Лекции по Информатике для 1-2 курсов.pdf" download>Лекции по Информатике для 1-2 курсов.pdf</a>
            </li>
        </ul>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>