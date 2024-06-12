<head>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>

<header class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-4">
                <h1>
                    <a href="<?php echo BASE_URL ?>">Программирование</a>
                </h1>
            </div>
            <nav class="col-8">
                <ul>
                    <li class="btn"><a href="<?php echo BASE_URL ?>">Главная</a></li>
                    <li class="btn"><a href="<?php echo BASE_URL . 'admin/files/files.php'?>">Лекции</a></li>
                    <li class="btn"><a href="<?php echo URL . 'tests.php'?>">Тесты</a></li>

                    <li class="btn">
                        <?php if (isset($_SESSION['id'])):?>
                            <a href="">
                                <i class="fa fa-user"></i>
                                <?php echo $_SESSION['login']; ?>
                            </a>
                            <ul>
                                <?php if ($_SESSION['admin']):?>
                                    <li class="btn"><a href="/mydinamic-site/admin/topics/index.php">Админ панель</a></li>
                                <?php endif; ?>
                                <li><a href="<?php echo BASE_URL . "logout.php";?>">Выход</a></li>
                            </ul>
                        <?php else: ?>
                            <a href="<?php echo BASE_URL . "log.php";?>">
                                <i class="fa fa-user"></i>
                                Вход
                            </a>
                            <ul>
                                <li><a href="<?php echo BASE_URL . "reg.php";?>"> Регистрация</a> </li>
                            </ul>
                        <?php endif; ?>

                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>