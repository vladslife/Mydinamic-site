<?php
    include "path.php";
    include SITE_ROOT . "/app/database/db.php";
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search-term'])){
        $posts = searchInTitleAndContent($_POST['search-term'],'posts','students');
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>My site</title>
</head>
<body>

<?php include("app/include/header.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!-- блок main -->
<div class="container">
    <div class="content row">
        <!-- Main Content -->
        <div class="main-content col-12">
            <h3>Результаты поиска</h3>
            <?php foreach ($posts as $post): ?>
                <div class="post row d-flex align-items-center">
                    <div class="img col-12 col-md-4">
                        <img src="<?=BASE_URL . 'assets/images/posts/' . $post['img'] ?>" alt="<?=$post['title']?>" class="img-thumbnail">
                    </div>
                    <div class="post_text col-12 col-md-8">
                        <h4>
                            <a href="<?=BASE_URL . 'single.php?=post=' . $post['id'];?>"><?=substr($post['title'], 0, 120)  ?></a>
                        </h4>
                        <i class="far fa-user"> <?=$post['username'];?></i>
                        <p class="preview-text">
                            <?=mb_substr($post['content'], 0, 55, 'UTF-8')?>
                        </p>
                    </div>
                </div>
        <?php endforeach; ?>

        </div>

        </div>
    </div>
</div>
<!-- sidebar Content END -->
<!-- блок main END -->

<!-- footer -->
<div class="footer container-fluid">
    <div class="footer-content container">
        <div class="row">
            <div class="footer-section about col-md-4 col-12">
                <h4 class="logo-text">Программирование</h4>
                <p>
                    Программирование - динамический сайт, созданный для прохождения тестов, чтения лекций, а также для защиты выпускной квалификационной работы
                </p>
                <div class="contact">
                    <span><i class="fas fa-phone"></i> &nbsp; 89135524472</span>
                    <span><i class="fas fa-envelope"></i> &nbsp; vlad02_25bor@mail.ru</span>
                </div>
                <div class="socials">
                    <a href="#"><i class="fab fa-vk"></i></a>
                </div>
            </div>

            <div class="footer-section links col-md-4 col-12">
                <h4>Ссылки</h4>
                <br>
                <ul>
                    <a href="#">
                        <li>События</li>
                    <a href="#">
                        <li>Лекции</li>
                    </a>
                    <a href="#">
                        <li>Тесты</li>
                    </a>
                </ul>
            </div>

            <div class="footer-section contact-form col-md-4 col-12">
                <h4>Контакты</h4>
                <br>
                <form action="index.html" method="post">
                    <input type="email" name="email" class="text-input contact-input" placeholder="Ваш email адрес...">
                    <textarea rows="4" name="message" class="text-input contact-input" placeholder="Ваше сообщение..."></textarea>
                    <button type="submit" class="btn btn-big contact-btn">
                        <i class="fas fa-envelope"></i>
                        Отправить
                    </button>
                </form>
            </div>

        </div>

        <div class="footer-bottom">
            &copy; Programming 2024 | designed by Vlads
        </div>
    </div>
</div>

</body>
</html>