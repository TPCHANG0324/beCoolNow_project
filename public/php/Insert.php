<?php
        include("conn.php");

       //---------------------------------------------------

       //建立SQL
       $sql = "INSERT INTO mydb.City(ID, CityPic1, CityPic2, CityPic3) VALUES (123, '123', '456', '789')";

       //執行
       $affectedRow = $pdo->exec($sql);
       if($affectedRow > 0){
              echo "新增成功!";
       }else{
              echo "新增失敗!";
       }
?>
