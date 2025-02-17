<?php

//取得前端的資料
$source = json_decode(file_get_contents("php://input"), true);
$ArticleID = htmlspecialchars($source['ArticleID']);

//檢查一下文章的 id 是否正常
if ($ArticleID <= 0) {
    echo json_encode([
        "success" => false,
        "message" => "無效的文章 ID"
    ]);
    exit;
}

include('conn.php');

try {
    // 開始事務
    $pdo->beginTransaction();

    // 先刪除相關的 message 記錄
    $stmt = $pdo->prepare("DELETE FROM G1_Message WHERE ForumBoard_ID = ?");
    $stmt->bindValue(1, $ArticleID);
    $stmt->execute();

    // 然後刪除 ForumBoard 記錄
    $stmt = $pdo->prepare("DELETE FROM G1_ForumBoard WHERE ID = ?");
    $stmt->bindValue(1, $ArticleID);
    $stmt->execute();

    // 提交事務
    $pdo->commit();

    echo json_encode([
        "success" => true,
        "message" => "文章已成功刪除"
    ]);
} catch (PDOException $e) {
    // 如果出現錯誤，回滾事務
    $pdo->rollBack();
    
    echo json_encode([
        "success" => false,
        "message" => "刪除文章失敗",
        "error" => $e->getMessage(),
        "articleID" => $ArticleID
    ]);
}

$pdo = null;

?>