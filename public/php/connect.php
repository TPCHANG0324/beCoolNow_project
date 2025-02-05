<?php

//建立資料庫連線
$URL = "mysql:host=127.0.0.1;dbname=mydb;charset=utf8";
$USERNAME = "root";
$PASSWORD = "password";

$pdo = new PDO($URL, $USERNAME, $PASSWORD);
// 如果連線錯誤會拋出 PDOException 異常
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>