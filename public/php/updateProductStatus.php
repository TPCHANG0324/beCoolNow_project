<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

include('conn.php'); // 連接資料庫

// **檢查請求**
$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data["productID"]) || !isset($data["productStatus"])) {
    echo json_encode(["success" => false, "error" => "缺少必要參數"]);
    exit;
}

$productID = intval($data["productID"]);
$productStatus = ($data["productStatus"] === 1) ? 1 : 0; // ✅ 確保只接受 1 或 0

try {
    // **確認商品是否存在**
    $stmt = $pdo->prepare("SELECT ID FROM G1_Product WHERE ID = ?");
    $stmt->execute([$productID]);
    if ($stmt->rowCount() === 0) {
        echo json_encode(["success" => false, "error" => "商品不存在"]);
        exit;
    }

    // **更新商品狀態**
    $stmt = $pdo->prepare("UPDATE G1_Product SET productStatus = ? WHERE ID = ?");
    $stmt->execute([$productStatus, $productID]);

    echo json_encode(["success" => true]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "error" => "資料庫錯誤: " . $e->getMessage()]);
}
?>
