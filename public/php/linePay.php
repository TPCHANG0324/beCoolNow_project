<?php

$channelId = '2006908631';
$channelSecret = '8d1e21d1a771f85398d2519cce026ffb';

$apiUrl = "https://sandbox-api-pay.line.me/v2/payments/request";
$request = "POST /v3/payments/request";

// 準備付款預約請求資料
$requestData = [
    "productName"      => "Test Product",                      // 產品名稱
    "productImageUrl"  => "https://picsum.photos/id/237/200/300",   // 產品圖片 URL（選填）
    "amount"           => 100,                                 // 訂單金額（整數）
    "currency"         => "TWD",                               // 貨幣
    "confirmUrl"       => "http://localhost/tid103/g1/php/linePay_confirm.php", // 用戶付款完成後 Line Pay 會重導回這個 URL
    "orderId"          => "ORDER" . time()                     // 訂單編號（請自行產生唯一值）
];

$jsonData = json_encode($requestData);

// 設定 HTTP 標頭
$headers = [
    "Content-Type: application/json",
    "X-LINE-ChannelId: " . $channelId,
    "X-LINE-ChannelSecret: " . $channelSecret
];

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

// 將回傳的 JSON 解碼為 PHP 陣列
$responseData = json_decode($response, true);
// 輸出回應內容，供測試檢查

print_r($responseData);

// 如果成功，則取得付款連結，並可依需求重導使用者
// if (isset($responseData['returnCode']) && $responseData['returnCode'] === "0000") {
//     echo "付款預約成功！<br>";
//     echo "請將使用者導向： " . $responseData['info']['paymentUrl']['web'];
//     // 若要自動重導，可以使用：
//     // header("Location: " . $responseData['info']['paymentUrl']['web']);
// } else {
//     echo "付款預約失敗： " . $responseData['returnMessage'];
// }
