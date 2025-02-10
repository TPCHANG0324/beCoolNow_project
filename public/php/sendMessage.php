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

// 取得前端的資料
$memberMessage = json_decode(file_get_contents("php://input"), true);
$Contents = htmlspecialchars($memberMessage['contents']);
$forumBoardId = htmlspecialchars($memberMessage['forumBoardId']);

include('connect.php');

try {
    // 開啟事務
    $pdo->beginTransaction();

    // 插入留言
    $sql1 = "INSERT INTO G1_Message (member_ID, messageContents, ForumBoard_ID)
             VALUES ((SELECT id FROM G2_MEMBER WHERE email = ?), ?, ?)";
    $stmt1 = $pdo->prepare($sql1);
    $stmt1->bindValue(1, $email);
    $stmt1->bindValue(2, $Contents);
    $stmt1->bindValue(3, $forumBoardId, PDO::PARAM_INT);
    $stmt1->execute();

    
    $sql2 = "UPDATE G1_ForumBoard 
             SET chat = (
                 SELECT COUNT(*) 
                 FROM G1_Message 
                 WHERE ForumBoard_ID = ? AND messageShelves = 1
             )
             WHERE ID = ?";
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->bindValue(1, $forumBoardId, PDO::PARAM_INT);
    $stmt2->bindValue(2, $forumBoardId, PDO::PARAM_INT);
    $stmt2->execute();

    // commit 事務
    $pdo->commit();

    echo json_encode([
        "success" => true,
        "message" => '留言成功！'
    ]);
} catch (PDOException $e) {
    // rollback 事務
    $pdo->rollBack();
    echo json_encode([
        "success" => false,
        "message" => "錯誤信息: " . $e->getMessage(),
    ]);
}

$pdo = null;

?>
