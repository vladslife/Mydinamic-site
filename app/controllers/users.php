<?php
include SITE_ROOT . "/app/database/db.php";

$errMsg = [];

function userAuth($user){
    $_SESSION['id'] = $user['id'];
    $_SESSION['login'] = $user['username'];
    $_SESSION['admin'] = $user['admin'];
    if($_SESSION['admin']){
        header('Location:' . BASE_URL . "admin/posts/index.php");
    }else{
        header('Location:' . BASE_URL . "students/student_dashboard.php");
    }
}

$users = selectAll('students');

//Код для регистрации
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['button-reg'])){

    $admin = 0;
    $login = trim($_POST['login']);
    $email = trim($_POST['mail']);
    $passF = trim($_POST['pass-first']);
    $passS = trim($_POST['pass-second']);

    if($login === '' || $email === '' || $passF === ''){
        array_push($errMsg, "Не все поля заполнены!");
    }elseif (mb_strlen($login, 'UTF-8') < 2){
        array_push($errMsg, "Логин должен быть более 2-х символов!");
    }elseif ($passF !== $passS) {
        array_push($errMsg, "Пароли должны совпадать!");
    }else{
        $existence = selectOne('students', ['email' => $email]);
        if($existence && isset($existence['email']) && $existence['email'] === $email){
            array_push($errMsg, "Данный email уже используется!");
        }else{
            $pass = password_hash($passF, PASSWORD_DEFAULT);
            $post = [
                'admin' => $admin,
                'username' => $login,
                'email' => $email,
                'password' => $pass,
            ];
            $id = insert('students', $post);
            $user = SelectOne('students', ['id' => $id]);

            userAuth($user);
        }
    }
}else {
    $login = '';
    $email = '';
}

//Код для формы авторизации
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['button-log'])) {

    $email = trim($_POST['mail']);
    $pass = trim($_POST['password']);

    if($email === '' || $pass === '') {
        array_push($errMsg, "Не все поля заполнены!");
    }else{
        $existence = selectOne('students', ['email' => $email]);
        if($existence && password_verify($pass, $existence['password'])) {
            userauth($existence);
        }else{
            array_push($errMsg, "Неверный Email или пароль!");
        }
    }
}else{
    $email = '';
}

//Код добавления пользователя в админке
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create-user'])){

    $admin = 0;
    $login = trim($_POST['login']);
    $email = trim($_POST['mail']);
    $passF = trim($_POST['pass-first']);
    $passS = trim($_POST['pass-second']);

    if($login === '' || $email === '' || $passF === ''){
        array_push($errMsg, "Не все поля заполнены!");
    }elseif (mb_strlen($login, 'UTF-8') < 2){
        array_push($errMsg, "Логин должен быть более 2-х символов!");
    }elseif ($passF !== $passS) {
        array_push($errMsg, "Пароли должны совпадать!");
    }else{
        $existence = selectOne('students', ['email' => $email]);
        if($existence && isset($existence['email']) && $existence['email'] === $email){
            array_push($errMsg, "Данный email уже используется!");
        }else{
            $pass = password_hash($passF, PASSWORD_DEFAULT);
            if(isset($_POST['admin'])) $admin = 1;
            $user = [
                'admin' => $admin,
                'username' => $login,
                'email' => $email,
                'password' => $pass,
            ];
            $id = insert('students', $user);
            $user = SelectOne('students', ['id' => $id]);
            userAuth($user);
        }
    }
}else {
    $login = '';
    $email = '';
}

// Код удаления пользователя в админке
if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete_id'])){
    $id = $_GET['delete_id'];
    delete('students', $id);
    header('location: ' . BASE_URL . 'admin/users/index.php');
}

// Редактирвоание пользователя через админку
if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['edit_id'])){
    $user = selectOne('students', ['id' => $_GET['edit_id']]);
    $id =  $user['id'];
    $admin =  $user['admin'];
    $username = $user['username'];
    $email = $user['email'];
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update-user'])) {

    $id = $_POST['id'];
    $mail = trim($_POST['mail']);
    $login = trim($_POST['login']);
    $passF = trim($_POST['pass-first']);
    $passS = trim($_POST['pass-second']);
    $admin = isset($_POST['admin']) ? 1 : 0;

    if ($login === '') {
        array_push($errMsg, "Не все поля заполнены!");
    } elseif (mb_strlen($login, 'UTF8') < 7) {
        array_push($errMsg, "Логин должен быть более 2-х символов");
    } elseif ($passF !== $passS) {
        array_push($errMsg, "Пароли в обоих полях должны соответствовать!");}
    else {
            $pass = password_hash($passF, PASSWORD_DEFAULT);
            if (isset($_POST['admin'])) $admin = 1;
            $user = [
                'admin' => $admin,
                'username' => $login,
//                'email' => $mail,
                'password' => $pass,
            ];

            $user = update('students', $id, $user);
            header('location: ' . BASE_URL . 'admin/users/index.php');
        }
    } else {
    // Инициализация переменной $user
    // Например, $user может быть результатом выборки из базы данных
    // $user = getUserById($userId); // Замените эту строку на вашу логику получения пользователя

    if (isset($user) && is_array($user)) {
        $id = isset($user['id']) ? $user['id'] : null;
        $admin = isset($user['admin']) ? $user['admin'] : null;
        $username = isset($user['username']) ? $user['username'] : '';
        $email = isset($user['email']) ? $user['email'] : '';
    } else {
        // Обработка случая, когда $user не определен или пуст
        $id = null;
        $admin = null;
        $username = '';
        $email = '';
    }
}
