<?php
/*
 * распечатка массива
 */
//function print_arr($arr){
//    echo '<pre>' . print_r($arr, true) . '/<pre>';
//}

///*
// *  получение списка тестов
// */
//function get_tests(){
//    global $conn;
//    $query = "SELECT * FROM test";
//    $res = mysqli_query($conn, $query);
//    if(!$res) return false;
//    $data = array();
//    while($row = mysqli_fetch_assoc($res)){
//        $data[] = $row;
//    }
//    return $data;
//}

///*
// * получение данных теста
// */
//function get_test_data($test_id){
//    if(!$test_id) return;
//    global $conn;
//    $query = "SELECT q.question_text, q.test_id, c.id, c.choice_text, c.question_id, c.is_correct
//    FROM questions q
//    LEFT JOIN choices c
//        ON q.id = c.question_id
//            WHERE q.test_id = $test_id";
//    $res = mysqli_query($conn, $query);
//    $data = null;
//    while ($row = mysqli_fetch_assoc($res)){
//        $data[$row['test_id']] [0] = $row['question_text'];
//        $data[$row['test_id']][$row['id']] = $row['choice_text'];
//    }
//    return $data;
//}

include '../../app/database/connect.php';
session_start();

// Проверка авторизации
if (!isset($_SESSION['id'])) {
    header('location: ' . BASE_URL . 'log.php');
    exit();
}

$user_id = $_SESSION['id'];
$test_id = isset($_GET['test_id']) ? (int)$_GET['test_id'] : 0;

if ($test_id === 0) {
    header('location: tests.php');
    exit();
}

$questions = $conn->query("SELECT * FROM questions WHERE test_id = $test_id");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $score = 0;

    foreach ($questions as $question) {
        $question_id = $question['id'];
        $user_answer = isset($_POST['question_' . $question_id]) ? $_POST['question_' . $question_id] : null;

        if ($question['question_type'] == 'multiple_choice') {
            $correct_choice = $conn->query("SELECT * FROM choices WHERE question_id = $question_id AND is_correct = 1")->fetch_assoc();
            if ($user_answer == $correct_choice['id']) {
                $score++;
            }
        } elseif ($question['question_type'] == 'matching') {
            $matches = $conn->query("SELECT * FROM matchings WHERE question_id = $question_id");
            $correct_matches = 0;
            foreach ($matches as $match) {
                $left = $match['match_left'];
                if ($user_answer[$left] == $match['match_right']) {
                    $correct_matches++;
                }
            }
            if ($correct_matches == $matches->num_rows) {
                $score++;
            }
        } elseif ($question['question_type'] == 'written') {
            $correct_answers = [
                4 => 'структурированный язык запросов',
                7 => 'HyperText Markup Language'
            ];
            if (strtolower($user_answer) == strtolower($correct_answers[$question_id])) {
                $score++;
            }
        }
    }

    $stmt = $conn->prepare("INSERT INTO students_results (student_id, test_id, score) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $user_id, $test_id, $score);
    if ($stmt->execute()) {
        header("Location: results.php?user_id=$user_id");
        exit();
    } else {
        echo "Ошибка при сохранении результатов: " . $stmt->error;
    }
}
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
    <h1 class="mt-4">Тест по программированию</h1>
    <form method="post">
        <?php foreach ($questions as $question): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $question['question_text']; ?></h5>
                    <?php if ($question['question_type'] == 'multiple_choice'): ?>
                        <?php
                        $choices = $conn->query("SELECT * FROM choices WHERE question_id = " . $question['id']);
                        foreach ($choices as $choice):
                            ?>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="question_<?php echo $question['id']; ?>" value="<?php echo $choice['id']; ?>" required>
                                <label class="form-check-label"><?php echo $choice['choice_text']; ?></label>
                            </div>
                        <?php endforeach; ?>
                    <?php elseif ($question['question_type'] == 'matching'): ?>
                        <?php
                        $matches = $conn->query("SELECT * FROM matchings WHERE question_id = " . $question['id']);
                        $left = [];
                        $right = [];
                        foreach ($matches as $match) {
                            $left[] = $match['match_left'];
                            $right[] = $match['match_right'];
                        }
                        shuffle($right);
                        ?>
                        <?php foreach ($left as $left_item): ?>
                            <div class="form-group">
                                <label><?php echo $left_item; ?></label>
                                <select class="form-control" name="question_<?php echo $question['id']; ?>[<?php echo $left_item; ?>]" required>
                                    <?php foreach ($right as $right_item): ?>
                                        <option value="<?php echo $right_item; ?>"><?php echo $right_item; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endforeach; ?>
                    <?php elseif ($question['question_type'] == 'written'): ?>
                        <div class="form-group">
                            <textarea class="form-control" name="question_<?php echo $question['id']; ?>" required></textarea>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
        <button type="submit" class="btn btn-primary">Отправить ответы</button>
    </form>
</div>
<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>