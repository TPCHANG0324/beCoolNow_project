<?php
// 存入訂單，回傳 `payment_url`


// 🛠️ 開啟錯誤回報（開發用，正式環境請關閉）
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// 設定 JSON 回應格式
header("Content-Type: application/json");

include 'conn.php';  // 連接資料庫


// 讀取 JSON 內容
$rawData = file_get_contents("php://input");
// error_log("📥 原始 JSON 請求內容: " . $rawData);

// 解析前端傳送的 JSON 訂單資料
$data = json_decode($rawData, true);
// $data = json_decode(file_get_contents("php://input"), true);


if (!$data) {
    echo json_encode(["success" => false, "message" => "❌ 無效的訂單資料"]);
    exit;
}


// 取得訂單資訊
$customer = $data['customer'];
$recipient = $data['recipient'];
$orderDetails = $data['orderDetails'];
$items = $data['items'];
$total = $data['total'];
$shippingFee = floatval($data['shippingFee']);  // 接收運費
$payMethod = intval($data['payMethod']);  // **✅ 接收付款方式**
$usePoints = $data['usePoints'] ?? 0; // 預設 0，避免 null 錯誤
$orderNotes = !empty($data['orderNotes']) ? $data['orderNotes'] : "無備註"; // 預設 "無備註"
$paymentInfo = $data['paymentInfo'];
$shipMethod = isset($data["shipMethod"]) ? intval($data["shipMethod"]) : 0; // 預設 0 = 新竹物流

// 付款狀態
$payStatus = 0; // 0 = 待付款, 1 = 已付款 先寫死


$memberID = 15; // 會員編號 寫死
// ✅ 取得會員 ID（這裡應該從 session 或 token 取得，而不是寫死）
// $memberID = isset($_SESSION['member_ID']) ? $_SESSION['member_ID'] : 1; // 假設使用者已登入

try {
    // ✅ 存入 `G1_Order` 資料表
    $sql = "INSERT INTO G1_Order (member_ID, customerName, customerEmail, customerPhone, recipientName, recipientEmail, recipientPhone, recipientAdress, total, usepoints, orderNotes, payStatus, shippingFee, payMethod, shipMethod)
            VALUES (:memberID, :cname, :cemail, :cphone, :rname, :remail, :rphone, :raddress, :total, :usePoints, :orderNotes, :payStatus, :shippingFee, :payMethod, :shipMethod)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':memberID' => $memberID ,
        ':cname' => $customer['name'],
        ':cemail' => $customer['email'],
        ':cphone' => $customer['phone'],
        ':rname' => $recipient['name'],
        ':remail' => $recipient['email'],
        ':rphone' => $recipient['phone'],
        ':raddress' => $recipient['address'],
        ':total' => $total,
        ':usePoints' => $usePoints,
        ':orderNotes' => $orderNotes,
        ':payStatus' => $payStatus,
        ':shippingFee' => $shippingFee,
        ':payMethod' => $payMethod,
        ':shipMethod'=> $shipMethod
    ]);


    // 取得新訂單的 ID
    $orderID = $pdo->lastInsertId();

    // 存入 `G1_OrderDetail` 資料表

    $sql = "INSERT INTO G1_OrderDetail (Order_ID, Product_ID, quantity, salePrice)
    VALUES (:Order_ID, :Product_ID, :quantity, :salePrice)";
    $stmt = $pdo->prepare($sql);

    foreach ($items as $item) {
        // $sql = "INSERT INTO G1_OrderDetail (order_id, product_id, quantity, salePrice)
        //         VALUES (:order_id, :product_id, :quantity, :salePrice)";
        // $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':Order_ID' => $orderID,
            ':Product_ID' => $item['id'], // 確保這是對應的 `product_id`
            ':quantity' => $item['num'],
            ':salePrice' => $item['salePrice']
        ]);
    }

    // 產生付款連結（導向 `ecpay_payment.php`）
    $payment_url = "/tid103/g1/ecpay_payment.php?Order_ID=" . $orderID;

    // ✅ 回傳成功訊息
    $response = [
        "success" => true,
        "payment_url" => $payment_url,
        "Order_ID" => $orderID
    ];

    // **記錄 API 回應**
    // error_log("📤 API 回應: " . json_encode($response, JSON_UNESCAPED_UNICODE));

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit;

    // ✅ 回傳成功訊息
    // echo json_encode(["success" => true,
    //                   "payment_url" => $payment_url,
    //                   "Order_ID" => $orderID // ✅ 確保前端能讀取 order_id
    //                 ]);

} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "❌ 資料庫錯誤：" . $e->getMessage()]);
}

exit;

?>
