<?php

ini_set("display_errors", 1);
error_reporting(-1);
require_once 'config.php';
require_once 'functions.php';

////список тестов
//$tests = get_tests();
//
//if( isset($_GET['test']) ){
//    $test_id = (int)$_GET['test'];
//    $test_data = get_test_data($test_id);
//    print_arr($test_data);
//}

?>
<!doctype html>
<html lang="ru">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Custom Styling -->
    <link rel="stylesheet" href="../../assets/css/test.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:wght@500;700&display=swap"
          rel="stylesheet">
    <title>Тестирование</title>
</head>
<body>

<!--<div class="wrap">-->
<!--    --><?php //if($tests): ?>
<!--        <h1>Список тестов</h1>-->
<!--        --><?php //foreach ($tests as $test) : ?>
<!--            <p><a href="?test=--><?php //=$test['id']?><!--">--><?php //=$test['test_name']?><!--</a></p>-->
<!--        --><?php //endforeach; ?>
<!---->
<!--    <br><hr><br>-->
<!--    <div class="content">-->
<!--        Вопросы выбранного теста-->
<!--    </div>-->
<!---->
<!--    --><?php //else: ?>
<!--        <h1>Нет тестов</h1>-->
<!--    --><?php //endif; ?>
<!--</div>-->

<!-- Optional JavaScript; choose one of the two! -->
<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+8W6rqkI0DOewxTh3I+uyKp1g6LkT"
        crossorigin="anonymous"></script>

</body>
</html>