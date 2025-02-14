<?php
// linepay_confirm.php

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');

// 請替換成你自己的通道憑證（正式環境請調整 URL）
$channelId = '2006908631';
$channelSecret = '8d1e21d1a771f85398d2519cce026ffb';
$apiUrl = "https://sandbox-api-pay.line.me"; // 沙箱環境

// 從 GET 參數中取得交易參數
$transactionId = isset($_GET['transactionId']) ? $_GET['transactionId'] : null;
$amount = isset($_GET['amount']) ? (int)$_GET['amount'] : 0;
$currency = isset($_GET['currency']) ? $_GET['currency'] : 'TWD';

if (!$transactionId || $amount <= 0) {
    echo json_encode([
        "success" => false,
        "message" => "缺少必要參數 (transactionId 或 amount)"
    ]);
    exit;
}

// 準備呼叫 confirm API 的資料
$requestData = [
    "transactionId" => $transactionId,
    "amount" => $amount,
    "currency" => $currency
];
$jsonData = json_encode($requestData);

// 設定請求 URL
$url = $apiUrl . "/v2/payments/confirm";

// 設定 HTTP 標頭
$headers = [
    "Content-Type: application/json",
    "X-LINE-ChannelId: " . $channelId,
    "X-LINE-ChannelSecret: " . $channelSecret
];

// 使用 cURL 呼叫 confirm API
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo json_encode([
        "success" => false,
        "message" => "Curl error: " . curl_error($ch)
    ]);
    exit;
}
curl_close($ch);

// 解析回應
$responseData = json_decode($response, true);

if (isset($responseData['returnCode']) && $responseData['returnCode'] === "0000") {
    // 交易確認成功，這裡可更新訂單狀態到資料庫
    // 例如：updateOrderStatus($transactionId, 'completed');
    
    // 最後，重定向使用者到付款成功頁面
    header("Location: /tid103/g1/Donatefinish");
    exit;
} else {
    echo json_encode([
        "success" => false,
        "message" => $responseData['returnMessage'] ?? "付款確認失敗",
        "response" => $responseData
    ]);
}
?>
