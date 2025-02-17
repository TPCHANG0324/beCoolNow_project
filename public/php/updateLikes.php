<?php

//建立連線
include('conn.php');

// 接收前端傳來的數據
$data = json_decode(file_get_contents('php://input'), true);
$articleId = $data['articleId'];
$action = $data['action'];

try {
    // 根據動作更新讚數
    if ($action === 'like') {
        $sql = "UPDATE G1_ForumBoard SET handup = handup + 1 WHERE id = :articleId";
    } else {
        $sql = "UPDATE G1_ForumBoard SET handup = GREATEST(handup - 1, 0) WHERE id = :articleId";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':articleId', $articleId);
    $stmt->execute();

    // 獲取更新後的讚數
    $sql = "SELECT handup FROM G1_ForumBoard WHERE id = :articleId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':articleId', $articleId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'newLikeCount' => $result['handup']
    ]);

} catch(PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => "Error: " . $e->getMessage()
    ]);
}

$pdo = null;


?>