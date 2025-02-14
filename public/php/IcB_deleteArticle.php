<?php
// delete.php

// 設定跨來源存取的 header 與 Content-Type
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');

// 載入連線設定（確保 connect.php 中正確定義 $dsn, $db_user, $db_pass, 並建立 $pdo）
include('conn.php');

try {
    // 從 GET 取得文章 ID
    $id = isset($_GET['id']) ? trim($_GET['id']) : '';

    if (empty($id)) {
        echo json_encode([
            'success' => false,
            'message' => '缺少必要的 id 參數'
        ]);
        exit;
    }

    // 準備刪除該筆記錄
    $sql = "DELETE FROM G1_Multimedia WHERE ID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    // 判斷是否有成功刪除記錄
    if ($stmt->rowCount() > 0) {
        echo json_encode([
            'success' => true,
            'message' => '文章刪除成功'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => '找不到該文章'
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
