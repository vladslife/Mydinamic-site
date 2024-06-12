php
<?php
include '../../app/database/connect.php';

if (isset($_GET['file_id'])) {
    $file_id = (int) $_GET['file_id'];

    $sql = "SELECT file_name, mime_type, file_size, file_data FROM filess WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $file_id);
    $stmt->execute();
    $stmt->bind_result($file_name, $mime_type, $file_size, $file_data);
    $stmt->fetch();

    if ($file_name) {
        header("Content-Type: " . $mime_type);
        header("Content-Disposition: attachment; filename=\"" . basename($file_name) . "\"");
        header("Content-Length: " . $file_size);

        echo $file_data;
    } else {
        echo "Файл не найден.";
    }

    $stmt->close();
}

$conn->close();
?>
