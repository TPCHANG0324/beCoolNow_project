<?php
// IcB_addArticle.php

// 設定跨來源存取的 header 與 Content-Type
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');

include('conn.php'); // 確保 connect.php 中已定義 $dsn, $db_user, $db_pass 並建立 $pdo

try {    
    // 取得 POST 傳來的資料
    // 假設前端傳送的欄位名稱為 title, url, image, content
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $url = isset($_POST['url']) ? trim($_POST['url']) : '';
    $image = isset($_POST['image']) ? trim($_POST['image']) : '';
    $content = isset($_POST['content']) ? trim($_POST['content']) : '';

    // 檢查必要欄位是否都有填寫
    if (empty($title) || empty($url) || empty($image) || empty( $content)) {
        echo json_encode([
            'success' => false,
            'message' => '請填寫所有必要欄位'
        ]);
        exit;
    }
    // 插入資料到 G1_Multimedia 表中（移除 ID 欄位，使用四個欄位）
    $sql = "INSERT INTO G1_Multimedia (mediaTitle, mediaURL, mediaPic, mediaContents) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$title, $url, $image, $content]);

    echo json_encode([
        'success' => true,
        'message' => '文章新增成功'
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
