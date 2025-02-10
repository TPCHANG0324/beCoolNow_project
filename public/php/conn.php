<?php
    //MySQL相關資訊
       $db_host = "localhost";
       $db_user = "root";
       $db_pass = "Touyhh9527!";
       $db_select = "g2";

       //建立資料庫連線物件
       $dsn = "mysql:host=".$db_host.";dbname=".$db_select.";charset=utf8";

       //建立PDO物件，並放入指定的相關資料
       $pdo = new PDO($dsn, $db_user, $db_pass);

       //---------------------------------------------------

?>
