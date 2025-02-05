<?php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

//建立連線
include('connect.php');

$articleId = isset($_GET['id']) ? $_GET['id'] : null;

$sql = "
    SELECT 
        f.ID,
        f.articleTitle AS title,
        f.content,
        f.editDate AS time,
        f.handup,
        f.chat,
        f.imageURL AS image,
        a.typeName AS category,
        m.account,
        m.imagePath
    FROM ForumBoard f
    JOIN ArticleType a ON f.articletype_ID = a.ID
    JOIN Member m ON f.member_ID = m.ID
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
    echo json_encode($articles);
} catch(PDOException $e) {
    echo json_encode(["error" => "資料庫連線失敗: " . $e->getMessage()]);
}

?>
