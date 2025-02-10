<?php
// editArticle.php
// 設定跨來源存取的 header 與 Content-Type
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');

include('connect.php');  // 確保 connect.php 定義了 $dsn, $user, $password

try {
    // 取得 POST 中傳來的資料
    // $id = isset($_POST['id']) ? trim($_POST['id']) : '';
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $url = isset($_POST['url']) ? trim($_POST['url']) : '';
    // $image = isset($_POST['image']) ? trim($_POST['image']) : '';
    $content = isset($_POST['content']) ? trim($_POST['content']) : '';

    if (empty($content) || empty($title) || empty($url)) {
        echo json_encode([
            'success' => false,
            'message' => '所有欄位皆必須填寫'
        ]);
        exit;
    }

    // 更新資料庫中對應的記錄
    $sql = "UPDATE G1_Multimedia SET mediaTitle = ?, mediaURL = ?, mediaContents = ? WHERE ID = 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$title, $url, $content]);

    echo json_encode([
        'success' => true,
        'message' => '文章更新成功'
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
