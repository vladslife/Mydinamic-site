<?php include "path.php";
      include "app/controllers/users.php";
      ?>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:wght@500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
  <title>My site</title>
</head>
<body>

<?php include("app/include/header.php"); ?>
<!-- END HEADER -->

<!-- FORM -->
<div class="container log_form">
  <form class="row justify-content-center" method="post" action="log.php">
    <h2 class="col-12">Авторизация</h2>
    <div class="mb-3 col-12 col-md-4 err">
        <?php if (isset($errMsg) && is_array($errMsg) && count($errMsg) > 0): ?>
            <ul>
                <?php foreach ($errMsg as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
    <div class="w-100"></div>
    <div class="mb-3 col-12 col-md-4">
      <label for="formGroupExampleInput" class="form-label">Email</label>
        <input name="mail" value="<?=$email?>" type="email" class="form-control" id="exampleInputEmail1" placeholder="Введите ваш email...">
    </div>
    <div class="w-100"></div>
    <div class="mb-3 col-12 col-md-4">
      <label for="exampleInputPassword1" class="form-label">Пароль</label>
      <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Введите ваш пароль...">
    </div>
    <!--        <div class="w-100"></div>-->
    <!--        <div class="filed recovery-password mb-3 col-12 col-md-4">-->
    <!--            <a href="">Забыли пароль или email?</a>-->
    <!--        </div>-->
    <div class="w-100"></div>
    <div class="mb-3 col-12 col-md-4">
      <button type="submit" name="button-log" class="btn btn-secondary" >Войти</button>
      <a href="reg.php">Зарегистрироваться</a>
    </div>
  </form>
</div>
<!-- END FORM -->