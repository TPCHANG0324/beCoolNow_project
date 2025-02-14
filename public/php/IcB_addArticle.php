<?php
// IcB_addArticle.php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');

include('conn.php'); // 確保 connect.php 中已定義 $dsn, $db_user, $db_pass 並建立 $pdo


try {
    $pdo = new PDO($dsn, $db_user, $db_pass); // 請確認 connect.php 中的變數名稱一致
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 取得 POST 文字資料
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $url = isset($_POST['url']) ? trim($_POST['url']) : '';
    $content = isset($_POST['content']) ? trim($_POST['content']) : '';

    // 檢查必要欄位
    if (empty($title) || empty($url)) {
        echo json_encode([
            'success' => false,
            'message' => '請填寫所有必要欄位'
        ]);
        exit;
    }

    // 處理圖片上傳
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/'; // 請確保此資料夾存在並具有寫入權限
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileNameParts = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameParts));
        // 產生一個新的檔案名稱，避免重複
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $destPath = $uploadDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $destPath)) {
            // 根據你的需求，將路徑存入資料庫（可以是相對路徑或完整 URL）
            // 例如，如果你的網站 URL 是 http://localhost/tid103/g1/，
            // 則完整 URL 為： http://localhost/tid103/g1/uploads/xxxx.jpg
            $imageUrl = 'http://localhost/tid103/g1/' . $destPath;
        } else {
            echo json_encode([
                'success' => false,
                'message' => '上傳圖片失敗'
            ]);
            exit;
        }
    } else {
        // 如果沒有上傳圖片，可設定預設圖片或空字串
        $imageUrl = '';
    }

    // 插入資料到 G1_Multimedia 表中（ID 為 AUTO_INCREMENT，不需傳入）
    $sql = "INSERT INTO G1_Multimedia (mediaTitle, mediaURL, mediaPic, mediaContents) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$title, $url, $imageUrl, $content]);

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
