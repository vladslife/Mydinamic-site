<?php

include SITE_ROOT . "/app/database/db.php";

$errMsg = '';
$id = '';
$name = '';
$description = '';
$topics = selectAll('topics');

//Код для создания категории
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['topic-create'])){

    $name = trim($_POST['name']);
    $description = trim($_POST['description']);

    if($name === '' || $description === ''){
        $errMsg = "Не все поля заполнены!";
    }elseif (mb_strlen($name, 'UTF-8') < 2){
        $errMsg = "Название должно быть более 2-х символов!";
    }else{
        $existence = selectOne('topics', ['name' => $name]);
        if($existence && isset($existence['name']) && $existence['name'] === $name){
            $errMsg = "Данное название уже используется!";
        }else{
            $topic = [
                'name' => $name,
                'description' => $description
            ];
            $id = insert('topics', $topic);
            $topic = SelectOne('topics', ['id' => $id]);
            header('Location:' . BASE_URL . 'admin/topics/index.php');
        }
    }
}else {
    $name = '';
    $description = '';
}

//Редактирование категории
if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])){
    $id = $_GET['id'];
    $topic = SelectOne('topics', ['id' => $id]);
    $id = $topic['id'];
    $name = $topic['name'];
    $description = $topic['description'];
}
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['topic-edit'])){
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);

    if($name === '' || $description === ''){
        $errMsg = "Не все поля заполнены!";
    }elseif (mb_strlen($name, 'UTF-8') < 2){
        $errMsg = "Название должно быть более 2-х символов!";
    }else{
        $topic = [
            'name' => $name,
            'description' => $description
        ];
        $id = $_POST ['id'];
        $topic_id = update('topics', $id, $topic);
        header('Location:' . BASE_URL . 'admin/topics/index.php');
    }
}
//Удаление категории
if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['del_id'])){
    $id = $_GET['del_id'];
    delete('topics', $id);
    header('Location:' . BASE_URL . 'admin/topics/index.php');
}