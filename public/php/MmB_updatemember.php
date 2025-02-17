<?php
include('conn.php'); // 確保有 PDO 連線
header("Content-Type: application/json; charset=UTF-8");

$data = json_decode(file_get_contents("php://input"), true);
if (!$data || !isset($data["id"])) {
    echo json_encode(["error" => "無效的請求"]);
    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE G2_MEMBER SET phoneNumber = ?, status = ? WHERE id = ?");
    $stmt->execute([
        $data["phoneNumber"],
        $data["status"],
        $data["id"]
    ]);

    echo json_encode(["success" => true]);
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
