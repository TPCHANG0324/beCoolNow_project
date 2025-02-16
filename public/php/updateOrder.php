<?php
header("Content-Type: application/json");
include('conn.php');

$method = $_SERVER['REQUEST_METHOD'];


$data = json_decode(file_get_contents("php://input"), true);
error_log("📌 接收到的數據：1111111111" . print_r($data, true));


if ($method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    // ✅ 檢查必填參數
    if (!isset($data['orderID']) || !isset($data['orderStatus']) || !isset($data['payStatus']) || !isset($data['payMethod']) || !isset($data['shipMethod']) || !isset($data['shipStatus']) || !isset($data['shippingFee'])) {
        error_log("❌ 缺少必要參數：22222222222" . print_r($data, true));
        echo json_encode(["success" => false, "message" => "缺少必要參數"]);
        exit;
    }

    $orderID = intval($data['orderID']);
    $orderStatus = intval($data['orderStatus']);
    $payStatus = intval($data['payStatus']);
    $payMethod = intval($data['payMethod']);
    $shipMethod = intval($data['shipMethod']);
    $shippingFee = floatval($data['shippingFee']);
    $shipStatus = intval($data['shipStatus']);
    try {

        // ✅ 紀錄 SQL 更新前的參數
        error_log("📌 更新訂單 ID33333333333: $orderID, orderStatus: $orderStatus, payStatus: $payStatus, shipStatus: $shipStatus, shippingFee: $shippingFee");

       // ✅ 更新 SQL
       $sql = "UPDATE G1_Order SET orderStatus = :orderStatus, payStatus = :payStatus, shippingFee = :shippingFee, shipStatus = :shipStatus, payMethod = :payMethod, shipMethod = :shipMethod WHERE ID = :orderID";
       $stmt = $pdo->prepare($sql);
       $stmt->bindParam(':orderStatus', $orderStatus, PDO::PARAM_INT);
       $stmt->bindParam(':payStatus', $payStatus, PDO::PARAM_INT);
       $stmt->bindParam(':payMethod', $payMethod, PDO::PARAM_INT);
       $stmt->bindParam(':shipMethod', $shipMethod, PDO::PARAM_INT);
       $stmt->bindParam(':shippingFee', $shippingFee, PDO::PARAM_STR);
       $stmt->bindParam(':shipStatus', $shipStatus, PDO::PARAM_INT);
       $stmt->bindParam(':orderID', $orderID, PDO::PARAM_INT);
       $stmt->execute();

        // ✅ 檢查是否有影響行數
        if ($stmt->rowCount() > 0) {
            echo json_encode(["success" => true, "message" => "訂單更新成功"]);
        } else {
            echo json_encode(["success" => false, "message" => "訂單未變更"]);
        }
    } catch (Exception $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }
}
?>
