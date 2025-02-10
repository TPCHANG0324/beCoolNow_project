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
        "message" => "請先登入！"
    ]);
    exit;
}

//取得前端的資料
$source = json_decode(file_get_contents("php://input"), true);
$messageID = htmlspecialchars($source['messageID']);

//檢查一下留言的 id 是否正常
if ($messageID <= 0) {
    echo json_encode([
        "success" => false,
        "message" => "無效的留言 ID"
    ]);
    exit;
}

include('connect.php');

$sql = "UPDATE G1_Message SET reportCount = reportCount + 1 WHERE ID = ?";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(1, $messageID, PDO::PARAM_INT); //整數處理


try {
    if ($stmt->execute()) {
        echo json_encode([
            "success" => true,
            "message" => '檢舉成功！',
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => '檢舉失敗！',
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