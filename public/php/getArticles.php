<?php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

//建立連線
include('conn.php');

//由查詢字串取得
$articleId = isset($_GET['id']) ? $_GET['id'] : null;

$sql = "
    SELECT
        f.ID,
        f.articleTitle AS title,
        f.articleShelves,
        f.content,
        f.editDate AS time,
        f.handup,
        f.chat,
        f.coverImageURL AS coverImage,
        a.typeName AS category,
        m.id AS memberId,
        m.account,
        m.imagePath
    FROM G1_ForumBoard f
    JOIN G1_ArticleType a ON f.articletype_ID = a.ID
    JOIN G2_MEMBER m ON f.member_ID = m.ID
";

//如果有指定文章 ID，則加入 WHERE 條件
if ($articleId) {
    $sql .= " WHERE f.ID = ?";
}

$sql .= " ORDER BY f.editDate DESC";

// 執行查詢
$stmt = $pdo->prepare($sql);


try {
    //如果有文章 ID，則綁定參數
    if ($articleId) {
        $stmt->bindValue(1, $articleId);
    }
    $stmt->execute();
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //要解碼的欄位
    $fieldsToDecodeMap = [
        'title',
        'account'
    ];
    $articles = array_map(function($article) use ($fieldsToDecodeMap) {
        foreach ($fieldsToDecodeMap as $field) {
            if (isset($article[$field])) {
                $article[$field] = htmlspecialchars_decode($article[$field]);
            }
        }
        return $article;
    }, $articles);

    //處理文章內容與封面圖
    foreach ($articles as &$article) {
        // 處理完整文章內容
        // 如果文章內容有圖片或其他HTML標籤，也可以直接回傳完整內容
        $article['content'] = $article['content']; // 這是完整內容

        // 處理封面圖片，如果是 Base64 編碼圖片，將其轉換為有效格式
        if ($article['coverImage']) {
            // 如果封面圖片是 Base64 編碼的，保留這樣的格式
            if (strpos($article['coverImage'], 'data:image') === false) {
                // 如果不是 Base64，可能是圖片路徑，結合相對路徑
                $article['coverImage'] = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($article['coverImage']));
            }
        }

        // 轉換成會員圖像路徑 (可選處理)
        // if ($article['imagePath']) {
        //     $article['imagePath'] = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($article['imagePath']));
        // }
    }

    // 回傳 JSON 格式資料
    echo json_encode([
        'success' => true,
        'data' => $articles
    ], JSON_UNESCAPED_UNICODE);

    // echo json_encode($articles);
} catch (PDOException $e) {
    echo json_encode(["error" => "資料庫連線失敗: " . $e->getMessage()]);
}
