<?php
// 設定跨來源存取的 header 與 Content-Type
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST'); // GET 或 POST 視需求而定
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json; charset=utf-8');

// include('conn.php');
include('connect.php');  // 確保 connect.php 定義了 $dsn, $user, $password


try {
    // 撈取文章資料，依 id 升冪排序
    $sql = "SELECT ID, mediaTitle,mediaURL,mediaPic,mediaContents FROM G1_Multimedia ORDER BY ID ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);  

    echo json_encode($articles);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
