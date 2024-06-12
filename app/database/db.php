<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require'connect.php';

function tt($value){
    echo '<pre>';
    print_r($value);
    echo '</pre>';
    exit();
}

// Проверка выполнения запроса к БД
function dbCheckError($query){
    $errInfo = $query->errorInfo();
    if($errInfo[0] !== PDO::ERR_NONE){
        echo $errInfo[2];
        exit();
    }
    return true;
}

// Запрос на получение данных с одной таблицы
function selectAll($table, $params = []){
    global $pdo;
    $sql = "SELECT * FROM $table";

    if(!empty($params)){
        $i = 0;
        foreach($params as $key => $value){
            if(!is_numeric($value)){
                $value = "'".$value."'";
            }
            if($i === 0){
                $sql = $sql . " WHERE $key = $value";
            }else{
                $sql = $sql . " AND $key = $value";
            }
            $i++;
        }
    }

    $query = $pdo->prepare($sql);
    $query->execute();
    dbcheckError($query);
    return $query->fetchAll();
}

// Запрос на получение одной строки с выбранной таблицы
function selectOne($table, $params = []){
    global $pdo;
    $sql = "SELECT * FROM $table";

    if(!empty($params)){
        $i = 0;
        foreach($params as $key => $value){
            if(!is_numeric($value)){
                $value = "'".$value."'";
            }
            if($i === 0){
                $sql = $sql . " WHERE $key = $value";
            }else{
                $sql = $sql . " AND $key = $value";
            }
            $i++;
        }
    }
//    $sql = $sql . " LIMIT 1";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbcheckError($query);
    return $query->fetch();
}



//$params = [
//    'admin' => 1,
//    'username' => 'Nika',
//];
//
//tt(selectAll('students', $params));
//tt(selectOne('students'));

// Запись в таблицу БД
function insert($table, $params){
    global $pdo;
    $i = 0;
    $coll = '';
    $mask = '';
    foreach($params as $key => $value) {
        if ($i === 0){
            $coll = $coll . "$key";
            $mask = $mask ."'" . "$value" . "'";
        }else {
            $coll = $coll . ", $key";
            $mask = $mask . ", '" . "$value" . "'" ;
            }
        $i++;
    }

    $sql = "INSERT INTO $table ($coll) VALUES ($mask)";

    $query = $pdo->prepare($sql);
    $query->execute();
    dbcheckError($query);
    return $pdo->lastInsertId();

}

// Обновление строки
//function update($table, $id, $params){
//    global $pdo;
//    $i = 0;
//    $str = '';
//    foreach($params as $key => $value) {
//        if ($i === 0){
//            $str = $str . $key . "= '" . $value . "'";
//        }else {
//            $str = $str .", " . $key . " = '" . $value . "'";
//        }
//        $i++;
//    }
//    // UPDATE `students` SET `username`='testik',`password`='555' WHERE `id` = 10
//    $sql = "UPDATE $table SET $str WHERE id = $id";
////    tt($sql);
////    exit();
//    $query = $pdo->prepare($sql);
//    $query->execute($params);
//    dbcheckError($query);
//
//}
//
//$param = [
//    'admin' => '0',
//    'password' => '321'
//];

//update('students', 10, $param);
function update($table, $id, $params){
    global $pdo;
    $setPart = [];
    foreach ($params as $key => $value) {
        $setPart[] = "$key = :$key";
    }
    $setPartStr = implode(', ', $setPart);

    // Формирование SQL запроса
    $sql = "UPDATE $table SET $setPartStr WHERE id = :id";

    $params['id'] = $id; // Добавление ID в массив параметров

    // Подготовка и выполнение запроса
    $query = $pdo->prepare($sql);
    $query->execute($params);
    dbcheckError($query);
}

function delete($table, $id){
    global $pdo;
    //DELETE FROM `students` WHERE id = 14
    // Формирование SQL запроса
    $sql = "DELETE FROM $table WHERE id = $id";
    // Подготовка и выполнение запроса
    $query = $pdo->prepare($sql);
    $query->execute();
    dbcheckError($query);
}
// Выборка записе(posts) с автором в админку
    function selectAllFromPostsWithUsers($table1, $table2){
        global $pdo;
        $sql = "
        SELECT 
        t1.id,
        t1.title,
        t1.img,
        t1.content,
        t1.status,
        t1.id_topic,
        t1.created_date,
        t2.username
        FROM $table1 AS t1 JOIN $table2 AS t2 ON t1.id_user = t2.id";
        $query = $pdo->prepare($sql);
        $query->execute();
        dbcheckError($query);
        return $query->fetchAll();

    }

// Выборка записе(posts) с автором на главную стр
function selectAllFromPostsWithUsersOnIndex($table1, $table2){
    global $pdo;
    $sql = "SELECT p.*, u.username FROM $table1 AS p JOIN $table2 AS u ON p.id_user = u.id WHERE p.status=1";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbcheckError($query);
    return $query->fetchAll();

}

// Поиск по заголовкам и содержимому (простой)
function searchInTitleAndContent($text, $table1, $table2){
    $text =trim(strip_tags(stripcslashes(htmlspecialchars($text))));
    global $pdo;
    $sql = "SELECT 
        p.*, u.username
        FROM $table1 AS p
        JOIN $table2 AS u
        ON p.id_user = u.id
        WHERE p.status=1
        AND p.title LIKE '%$text%' OR p.content LIKE '%$text%'";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbcheckError($query);
    return $query->fetchAll();

}

// Выборка записи с автором на сингл стр
function selectPostFromPostsWithUsersOnSingle($table1, $table2, $id){
    global $pdo;
    $sql = "SELECT p.*, u.username FROM $table1 AS p JOIN $table2 AS u ON p.id_user = u.id WHERE p.id=$id";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetch();

}