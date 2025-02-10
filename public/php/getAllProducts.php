<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *"); // 允許跨來源請求 (CORS)
header("Access-Control-Allow-Methods: GET");

// 建立PDO連線
include('conn.php');

try {

    // 取得所有商品
    $sql = "SELECT
            ID,
            productName,
            price,
            salePrice,
            saleCount,
            inventory,
            productPic1,
            productPic2,
            productPic3,
            OrderDetail_ID
        FROM g2.G1_Product
        ORDER BY ID DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($products);
} catch (PDOException $e) {
    echo json_encode(["error" => "查詢失敗: " . $e->getMessage()]);
}


?>
