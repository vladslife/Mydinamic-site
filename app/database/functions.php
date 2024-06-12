<?php
if (!function_exists('dbCheckError')) {
    function dbCheckError($query) {
        $errInfo = $query->errorInfo();
        if ($errInfo[0] !== PDO::ERR_NONE) {
            echo $errInfo[2];
            exit();
        }
        return true;
    }
}

if (!function_exists('selectAll')) {
    function selectAll($table) {
        global $pdo;

        $sql = "SELECT * FROM $table";
        $query = $pdo->prepare($sql);
        $query->execute();
        dbCheckError($query);

        return $query->fetchAll();
    }
}