<?php

//建立連線
include('conn.php');

//查詢個人文章
$source = json_decode(file_get_contents("php://input"), true);
$memberId = htmlspecialchars($source['memberId']);

if (!isset($memberId)) {
    echo json_encode([
        "success" => false,
        "message" => "沒有會員ID"
    ]);
    exit;
}

$sql = "
    SELECT 
    f.ID,
    f.articleTitle AS title,
    f.articleShelves,
    f.editDate AS time,
    a.typeName AS category
    FROM G1_ForumBoard f
    JOIN G1_ArticleType a ON f.articletype_ID = a.ID
    JOIN G2_MEMBER m ON f.member_ID = m.ID
    WHERE f.member_ID = ?
";

$stmt = $pdo->prepare($sql);

try {
    $stmt->bindValue(1, $memberId);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($data as &$dat) {
        $dat['title'] = htmlspecialchars_decode($dat['title']);
    }

    unset($dat);//解除參考
    
    echo json_encode([
        'success' => true,
        'data' => $data
    ]);
} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "error" => "資料庫連線失敗: " . $e->getMessage()
    ]);
}
