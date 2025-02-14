<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json; charset=utf-8');

session_start();

// 檢查是否已登入
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    echo json_encode([
        "success" => false,
        "message" => "驗證失敗，請先登入！"
    ]);
    exit;
}

$email = $_SESSION['email'];

include('connect.php');

try {
    $pdo->beginTransaction();

    // 獲取文章數據
    $articleData = json_decode(file_get_contents("php://input"), true);

    // 基本資料驗證
    if (empty($articleData['title']) || empty($articleData['content'])) {
        throw new Exception("缺少必要資料");
    }

    // 處理文章內容中的圖片
    $content = $articleData['content'];
    $base64Regex = '/src="data:image\/([^;]+);base64,([^"]+)"/';

    // 創建圖片存儲目錄
    $uploadDir = __DIR__ . '/uploads/' . date('Y/m/');
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // 替換所有 Base64 圖片為實際文件
    $content = preg_replace_callback($base64Regex, function ($matches) use ($uploadDir) {
        $imageType = $matches[1];
        $imageData = base64_decode($matches[2]);

        // 生成唯一文件名
        $fileName = uniqid() . '.' . $imageType;
        $filePath = $uploadDir . $fileName;

        if (file_put_contents($filePath, $imageData) === false) {
            throw new Exception("無法儲存圖片到路徑：$filePath");
        }

        //正式服的路徑修改
        // $line = "https://tibamef2e.com/tid103/g1/php/uploads/";
        $line = "http://localhost/tid103/g1/php/uploads/";
        
        return 'src="' . $line . date('Y/m/') . $fileName . '"';
    }, $content);

    // 準備封面圖片 URL（假設前端傳來封面圖片 URL）
    $coverImage = isset($articleData['hasThumbnail']) && $articleData['hasThumbnail'] ? $articleData['thumbnailUrl'] : null;

    // 插入文章
    $sql = "INSERT INTO G1_ForumBoard (articleTitle, content, articletype_ID, member_ID, coverImageUrl) 
            VALUES (?, ?, ?, (SELECT id FROM G2_MEMBER WHERE email = ?), ?)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        htmlspecialchars($articleData['title']),
        $content,
        $articleData['theme'],
        $email,
        $articleData['hasThumbnail'] ? $articleData['thumbnailUrl'] : null
    ]);

    $articleId = $pdo->lastInsertId();

    $pdo->commit();

    echo json_encode([
        "success" => true,
        "message" => "文章發布成功！",
        "articleId" => $articleId
    ]);
} catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode([
        "success" => false,
        "message" => "錯誤信息: " . $e->getMessage()
    ]);
}

$pdo = null;
