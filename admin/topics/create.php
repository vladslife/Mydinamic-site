<?php
    include "../../path.php";
    include "../../app/controllers/topics.php";
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
                <a href="<?php echo BASE_URL . "admin/topics/create.php";?>" class="col-3 btn btn-success">Добавить</a>
                <span class="col-1"></span>
                <a href="<?php echo BASE_URL . "admin/topics/index.php";?>" class="col-3 btn btn-warning">Изменить</a>
            </div>
            <div class="row title-table">
                <h2>Создать категорию</h2>
            </div>
            <div class="row add-post">
                <div class="mb-12 col-12 col-md-12 err">
                    <p><?=$errMsg?></p>
                </div>
                <form action="create.php" method="post">
                    <div class="col">
                        <input name="name" value="<?=$name;?>" type="text" class="form-control" placeholder="Название категории" aria-label="Название категории">
                    </div>
                    <div class="col">
                        <label for="content" class="form-label">Описание категории</label>
                        <textarea name="description" class="form-control" id="content" rows="3"><?=$description;?></textarea>
                    </div>
                    <div class="col">
                        <button name="topic-create" class="btn btn-primary" type="submit">Добавить категорию</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--footer -->
<?php include("../../app/include/footer.php"); ?>
<!-- // footer -->



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>