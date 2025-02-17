<?php
session_start();
$channelId = '2006908631';
$channelSecret = '8d1e21d1a771f85398d2519cce026ffb';

$apiUrl = "https://sandbox-api-pay.line.me/v2/payments/request";
$request = "POST /v3/payments/request";

//取得前端的資料
$source = json_decode(file_get_contents("php://input"), true);
$productName = htmlspecialchars($source['productName']);
$amount = htmlspecialchars($source['amount']);

//這段用來存前端捐款者的資料
$userData = $source['userData'] ?? null;
if (!$userData) {
    http_response_code(400);
    echo json_encode(['error' => '缺少使用者資料']);
    exit;
}
$_SESSION['userData'] = $userData;


// 準備付款預約請求資料
$requestData = [
    "productName"      => $productName,                      // 產品名稱
    "productImageUrl"  => "https://picsum.photos/id/237/200/300",   // 產品圖片 URL（選填）
    "amount"           => $amount,                                 // 訂單金額（整數）
    "currency"         => "TWD",                               // 貨幣
    "confirmUrl"       => "https://tibamef2e.com/tid103/g1/php/linePay_confirm.php?amount={$amount}", // 用戶付款完成後 Line Pay 會重導回這個 URL
    "orderId"          => "ORDER" . time()                     // 訂單編號
];

$jsonData = json_encode($requestData);

// 設定 HTTP 標頭
$headers = [
    "Content-Type: application/json",
    "X-LINE-ChannelId: " . $channelId,
    "X-LINE-ChannelSecret: " . $channelSecret
];

try {
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
        exit;
    }
    curl_close($ch);

    $responseData = json_decode($response, true);
    echo json_encode($responseData);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'returnCode' => 'ERROR',
        'returnMessage' => $e->getMessage()
    ]);
}
