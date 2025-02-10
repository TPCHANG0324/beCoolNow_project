<?php
//IcBqna_fetch.php
// 設定跨來源存取的 header 與 Content-Type
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST'); // GET 或 POST 視需求而定
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json; charset=utf-8');

include('connect.php');

try {
    // 撈取文章資料，依 id 升冪排序
    $sql = "SELECT ID, question,option1,option2,option3 FROM G1_QnA ORDER BY ID ASC";
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
