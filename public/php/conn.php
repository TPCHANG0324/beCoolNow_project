<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json; charset=utf-8');

    //MySQL相關資訊
        // $db_host = "localhost";
        // $db_host = "34.58.74.78";
        // $db_user = "root";
        // $db_pass = "Touyhh9527!";
        // $db_select = "g2";

        // 緯育資料庫
        $db_host = "127.0.0.1";
        $db_user = "tibamefe_since2021";
        $db_pass = "vwRBSb.j&K#E";
        $db_select = "tibamefe_tid103g2";

       //建立資料庫連線物件
       $dsn = "mysql:host=".$db_host.";dbname=".$db_select.";charset=utf8";

       //建立PDO物件，並放入指定的相關資料
       $pdo = new PDO($dsn, $db_user, $db_pass);

       //---------------------------------------------------

?>
