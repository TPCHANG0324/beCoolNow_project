<?php
// IcB_addArticle.php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');

include('connect.php');  // 確保 connect.php 定義了 $dsn, $db_user, $db_pass

$limit = 4; 

try {
    $pdo = new PDO($dsn, $db_user, $db_pass); // 請確認 connect.php 中的變數名稱一致
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 取得目前文章數量，並為 COUNT 結果命名為 total
    $countStmt = $pdo->query("SELECT COUNT(*) AS total FROM G1_Multimedia");
    $row = $countStmt->fetch(PDO::FETCH_ASSOC);
    $currentCount = $row['total'];

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
    
    // 檢查是否超過數量上限
    if ($currentCount >= $limit) {
        echo json_encode([
            'success' => false,
            'message' => '文章數量已達上限'
        ]);
        exit;
    }

    // 處理圖片上傳
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/'; // 確保此資料夾存在並具有寫入權限
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
            // 儲存相對路徑或完整 URL，這邊採用相對路徑
            $imageUrl = $destPath;
        } else {
            echo json_encode([
                'success' => false,
                'message' => '上傳圖片失敗'
            ]);
            exit;
        }
    } else {
        // 若沒有上傳圖片，則設定為空字串或預設圖片
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
