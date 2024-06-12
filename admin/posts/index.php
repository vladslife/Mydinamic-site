<?php
    include "../../path.php";
    include "../../app/controllers/posts.php";
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
    <title>My site</title>
</head>
<body>

<?php include"../../app/include/header-admin.php"; ?>

<div class="container">
<?php include "../../app/include/sidebar-admin.php"; ?>

        <div class="posts col-9">
            <div class="button row">
                <a href="<?php echo BASE_URL . "admin/posts/create.php";?>" class="col-3 btn btn-success">Добавить</a>
                <span class="col-1"></span>
                <a href="<?php echo BASE_URL . "admin/posts/index.php";?>" class="col-3 btn btn-warning">Изменить</a>
            </div>
            <div class="row title-table">
                <h2>Управление записями</h2>
                <div class="col-1">ID</div>
                <div class="col-3">Название</div>
                <div class="col-2">Автор</div>
                <div class="col-6"><a href="">Управление</a></div>
            </div>
            <?php foreach ($postsAdm as $key => $post): ?>
                <div class="row post">
                    <div class="id col-1"><?=$key + 1; ?></div>
                    <div class="title col-3"><?=mb_substr($post['title'], 0, 50, 'UTF-8')?></div>
                    <div class="author col-2"><?=$post['username']; ?></div>
                    <div class="red col-2"><a href="edit.php?id=<?=$post['id'];?>">Изменить</a></div>
                    <div class="del col-2"><a href="edit.php?delete_id=<?=$post['id'];?>">Удалить</a></div>
                    <?php if ($post['status']): ?>
                        <div class="status col-2"><a href="edit.php?publish=0&pub_id=<?=$post['id'];?>">Опубликовать</a></div>
                    <?php else: ?>
                        <div class="status col-2"><a href="edit.php?publish=1&pub_id=<?=$post['id'];?>">Неопубликованная</a></div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
</div>
</div>
<!--            <div class="row post">-->
<!--                <div class="id col-1">1</div>-->
<!--                <div class="title col-4">Название</div>-->
<!--                <div class="author col-2">Автор</div>-->
<!--                <div class="red col-3"><a href="">Редактировать</a></div>-->
<!--                <div class="del col-2"><a href="">Удалить</a></div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<!--footer -->
<?php include("../../app/include/footer.php"); ?>
<!-- // footer -->



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>