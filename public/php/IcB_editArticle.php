<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');

include('connect.php'); 

try {
    $id = isset($_POST['id']) ? trim($_POST['id']) : '';
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $url = isset($_POST['url']) ? trim($_POST['url']) : '';
    $content = isset($_POST['content']) ? trim($_POST['content']) : '';
    $image = isset($_FILES['image']) ? $_FILES['image'] : null;

    // 檢查所有必要欄位（允許 image 為 null）
    if (empty($title) || empty($url) || empty($content)) {
        echo json_encode([
            'success' => false,
            'message' => '所有欄位皆必須填寫'
        ]);
        exit;
    }

    // 處理圖片上傳
    $imagePath = null;
    if ($image && $image['error'] === UPLOAD_ERR_OK) {
        $imagePath = 'uploads/' . basename($image['name']);
        move_uploaded_file($image['tmp_name'], $imagePath);
    }

    // 更新 SQL
    $sql = "UPDATE G1_Multimedia SET mediaTitle = ?, mediaURL = ?, mediaContents = ?" . ($imagePath ? ", mediaPic = ?" : "") . " WHERE ID = ?";
    $stmt = $pdo->prepare($sql);

    // 執行 SQL
    $params = [$title, $url, $content];
    if ($imagePath) {
        $params[] = $imagePath;
    }
    $params[] = (int)$id;

    if ($stmt->execute($params)) {
        echo json_encode([
            'success' => true,
            'message' => '文章更新成功'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => '更新失敗：執行 SQL 時發生錯誤'
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
