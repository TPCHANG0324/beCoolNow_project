<?php


//取得前端的資料
$source = json_decode(file_get_contents("php://input"), true);
$messageID = htmlspecialchars($source['messageID']);
$forumBoardId = htmlspecialchars($source['forumBoardId']);

//檢查一下留言的 id 是否正常
if ($messageID <= 0) {
    echo json_encode([
        "success" => false,
        "message" => "無效的留言 ID"
    ]);
    exit;
}

include('conn.php');

try {
    // 開啟事務
    $pdo->beginTransaction();

    // 更新留言的 messageShelves 狀態
    $sql1 = "UPDATE G1_Message SET messageShelves = 0 WHERE ID = ?";
    $stmt1 = $pdo->prepare($sql1);
    $stmt1->bindValue(1, $messageID, PDO::PARAM_INT); // 整數處理
    $stmt1->execute();

    // 更新 G1_ForumBoard 的 chat 欄位
    $sql2 = "UPDATE G1_ForumBoard 
             SET chat = (
                 SELECT COUNT(*) 
                 FROM G1_Message 
                 WHERE ForumBoard_ID = ? AND messageShelves = 1
             )
             WHERE ID = ?";
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->bindValue(1, $forumBoardId);
    $stmt2->bindValue(2, $forumBoardId);
    $stmt2->execute();

    // commit 事務
    $pdo->commit();

    echo json_encode([
        "success" => true,
        "message" => '刪除成功！',
    ]);
} catch (PDOException $e) {
    // rollback 事務
    $pdo->rollBack();
    echo json_encode([
        'success' => false,
        'message' => "Error: " . $e->getMessage()
    ]);
}

$pdo = null;

?>