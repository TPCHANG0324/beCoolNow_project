<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *"); // 允許跨來源請求
header("Access-Control-Allow-Methods: GET");

include('conn.php'); // 確保資料庫連線正常

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET' && isset($_GET['member_ID'])) {
    $member_ID = intval($_GET['member_ID']);

    try {
        $sql = "SELECT G1_Order.ID AS orderId, G1_Order.buyDate AS date,
                        G1_Order.shipStatus AS status, G1_Order.shippingFee,
                        G1_OrderDetail.salePrice AS price, G1_OrderDetail.quantity,
                        G1_Product.productName, G1_Order.recipientAdress AS address
                FROM G1_Order
                JOIN G1_OrderDetail ON G1_Order.ID = G1_OrderDetail.Order_ID
                JOIN G1_Product ON G1_OrderDetail.Product_ID = G1_Product.ID
                WHERE G1_Order.member_ID = :member_ID
                ORDER BY G1_Order.buyDate ASC";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':member_ID', $member_ID, PDO::PARAM_INT);
        $stmt->execute();
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            "success" => true,
            "records" => $records
        ]);
    } catch (Exception $e) {
        echo json_encode([
            "success" => false,
            "message" => $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request"
    ]);
}
?>
