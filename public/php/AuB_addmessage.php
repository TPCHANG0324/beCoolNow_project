<?php
include('conn.php'); // 確保與 MySQL 連線

header('Content-Type: application/json');

// 確保請求方式為 POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    $name = $data['name'] ?? '';
    $email = $data['email'] ?? '';
    $phone = $data['phone'] ?? '';
    $message = $data['message'] ?? '';

    // 基本驗證
    if (!$name || !$email || !$phone || !$message) {
        echo json_encode(['error' => '所有欄位皆為必填']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO G1_ContactUS (name, `e-mail`, cellPhone, contactContents) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $phone, $message]);

        echo json_encode(['message' => '資料成功新增']);
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => '不支援的請求方式']);
}
?>
