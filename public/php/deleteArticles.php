<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json; charset=utf-8');

// session_start();

// // 檢查是否已登入
// if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
//     echo json_encode([
//         "success" => false,
//         "message" => "請先登入！"
//     ]);
//     exit;
// }

//取得前端的資料
$source = json_decode(file_get_contents("php://input"), true);
$ArticleID = htmlspecialchars($source['ArticleID']);
$shelfStatus = htmlspecialchars($source['shelfStatus']);

//檢查一下文章的 id 是否正常
if ($ArticleID <= 0) {
    echo json_encode([
        "success" => false,
        "message" => "無效的文章 ID"
    ]);
    exit;
}

include('conn.php');

$sql = "UPDATE G1_ForumBoard SET articleShelves = ? WHERE ID = ?";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(1, $shelfStatus);
$stmt->bindValue(2, $ArticleID);

try {
    if ($stmt->execute()) {
        echo json_encode([
            "success" => true,
            "message" => '下架成功！',
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => '下架失敗！',
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => "Error: " . $e->getMessage()
    ]);
}


$pdo = null;

?>