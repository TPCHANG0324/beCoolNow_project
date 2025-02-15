<?php

// header("Content-Type: application/json; charset=UTF-8");
// header('Access-Control-Allow-Credentials: true');
// header("Access-Control-Allow-Origin: *");

//建立連線
include('conn.php');

$forumBoardId = isset($_GET['id']) ? $_GET['id'] : '';

$sql = "SELECT
          m.id AS messageID,
          m.member_ID AS memberID, 
          m.messageContents AS content,
          m.messageDate,
          m.messageShelves,
          m.reportCount,
          m.ForumBoard_ID AS articleID,
          mem.account AS nickname,
          mem.imagePath AS avatar
        FROM G1_Message AS m
        JOIN G2_MEMBER AS mem ON m.member_ID = mem.id";


if ($forumBoardId) {
    $sql .= " WHERE m.ForumBoard_ID = ?";
}


$stmt = $pdo->prepare($sql);

try {
    if ($forumBoardId) {
        $stmt->bindValue(1, $forumBoardId);
    }
    $stmt->execute();
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode([
        "success" => true,
        "messages" => $messages
    ]);
} catch (PDOException $e) {
    echo json_encode(["error" => "資料庫連線失敗: " . $e->getMessage()]);
}
