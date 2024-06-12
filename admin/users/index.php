<?php session_start();
include "../../path.php";
include "../../app/controllers/users.php";
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

<?php include("../../app/include/header-admin.php"); ?>

<div class="container">
    <?php include "../../app/include/sidebar-admin.php"; ?>
    <div class="posts col-9">
        <div class="button row">
            <a href="<?php echo BASE_URL . "admin/users/create.php";?>" class="col-2 btn btn-success">Создать</a>
            <span class="col-1"></span>
            <a href="<?php echo BASE_URL . "admin/users/index.php";?>" class="col-3 btn btn-warning">Редактировать</a>
        </div>
        <div class="row title-table">
            <h2>Пользователи</h2>
            <div class="col-1">ID</div>
            <div class="col-2">Логин</div>
            <div class="col-3">Email</div>
            <div class="col-3">Роль</div>
            <div class="col-3">Управление</div>
        </div>
        <?php foreach ($users as $key => $user): ?>
            <div class="row post">
                <div class="col-1"><?=$user['id'];?></div>
                <div class="col-2"><?=$user['username'];?></div>
                <div class="col-3"><?=$user['email'];?></div>
                <?php if ($user['admin'] == 1): ?>
                    <div class="col-2">Учитель</div>
                <?php else: ?>
                    <div class="col-2">Студент</div>
                <? endif; ?>
                <div class="red col-2"><a href="edit.php?edit_id=<?=$user['id'];?>">Изменить</a></div>
                <div class="del col-2"><a href="index.php?delete_id=<?=$user['id'];?>">Удалить</a></div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</div>

<!--footer -->
<?php include("../../app/include/footer.php"); ?>
<!-- // footer -->



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
