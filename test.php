<?php
include 'app/database/connect.php';
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit;
}

$student_id = $_SESSION['student_id'];
$test_id = $_GET['test_id'];

// Получение вопросов и ответов для теста
$sql = "SELECT q.id AS question_id, q.question_text, q.question_type, a.id AS answer_id, a.answer_text, a.is_correct
        FROM questions q
        LEFT JOIN answers a ON q.id = a.question_id
        WHERE q.test_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $test_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($question_id, $question_text, $question_type, $answer_id, $answer_text, $is_correct);

$questions = [];
while ($stmt->fetch()) {
    $questions[$question_id]['text'] = $question_text;
    $questions[$question_id]['type'] = $question_type;
    if ($answer_id) {
        $questions[$question_id]['answers'][] = ['id' => $answer_id, 'text' => $answer_text, 'is_correct' => $is_correct];
    }
}
$stmt->close();

// Обработка отправки ответов
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $score = 0;
    foreach ($questions as $question_id => $question) {
        if ($question['type'] == 'multiple_choice' && isset($_POST["question_$question_id"])) {
            foreach ($question['answers'] as $answer) {
                if ($answer['id'] == $_POST["question_$question_id"] && $answer['is_correct']) {
                    $score++;
                }
            }
        } elseif ($question['type'] == 'short_answer' && isset($_POST["question_$question_id"])) {
            foreach ($question['answers'] as $answer) {
                if (strcasecmp($answer['text'], $_POST["question_$question_id"]) == 0) {
                    $score++;
                }
            }
        }
    }

    $sql = "INSERT INTO results (student_id, test_id, score) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $student_id, $test_id, $score);
    if ($stmt->execute()) {
        header("Location: student_dashboard.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Test</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h1>Take Test</h1>
    <form action="test.php?test_id=<?= $test_id ?>" method="post">
        <?php foreach ($questions as $question_id => $question) : ?>
            <div class="form-group">
                <label><?= $question['text'] ?></label>
                <?php if ($question['type'] == 'multiple_choice') : ?>
                    <?php foreach ($question['answers'] as $answer) : ?>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question_<?= $question_id ?>" value="<?= $answer['id'] ?>">
                            <label class="form-check-label"><?= $answer['text'] ?></label>
                        </div>
                    <?php endforeach; ?>
                <?php elseif ($question['type'] == 'short_answer') : ?>
                    <input type="text" class="form-control" name="question_<?= $question_id ?>">
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>