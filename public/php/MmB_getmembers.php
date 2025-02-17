<?php
include('conn.php'); // 確保有 PDO 連線
header("Content-Type: application/json; charset=UTF-8");

try {
    $stmt = $pdo->prepare("SELECT id, account, email, phoneNumber, status, createTime FROM G2_MEMBER ORDER BY id ASC");
    $stmt->execute();
    $members = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($members);
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
