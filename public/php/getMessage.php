<?php

header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Origin: *");

//建立連線
include('connect.php');

$forumBoardId = isset($_GET['id']) ? $_GET['id'] : '';

if (!$forumBoardId) {
    echo json_encode([
        "success" => false,
        "message" => "缺少文章 ID"
    ]);
    exit;
}

$sql = "SELECT
          m.id AS messageID,
          m.member_ID AS memberID, 
          m.messageContents AS content,
          m.messageDate,
          m.messageShelves,
          mem.account AS nickname,
          mem.imagePath AS avatar
        FROM G1_Message AS m
        JOIN G2_MEMBER AS mem ON m.member_ID = mem.id
        WHERE m.ForumBoard_ID = ?";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(1, $forumBoardId, PDO::PARAM_INT); //此為整數
$stmt->execute();

$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    "success" => true,
    "messages" => $messages
]);


?>