<?php

//建立資料庫連線
$URL = "mysql:host=127.0.0.1;dbname=pdo;charset=utf8";
$USERNAME = "root";
$PASSWORD = "password";

$pdo = new PDO($URL, $USERNAME, $PASSWORD);


?>
