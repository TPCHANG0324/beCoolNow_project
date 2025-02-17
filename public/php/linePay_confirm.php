<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

$channelId = '2006908631';
$channelSecret = '8d1e21d1a771f85398d2519cce026ffb';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$transactionId = $_GET['transactionId'] ?? '';
$orderId = $_GET['orderId'] ?? '';
$amount = $_GET['amount'] ?? 0;
$userData = $_SESSION['userData'] ?? null; //上一步存的捐款者資訊

if (!empty($transactionId)) {
    try {
        $url = "https://sandbox-api-pay.line.me/v2/payments/{$transactionId}/confirm";
        
        $confirmData = [
            "amount" => intval($amount),
            "currency" => "TWD"
        ];

        $headers = [
            "Content-Type: application/json",
            "X-LINE-ChannelId: " . $channelId,
            "X-LINE-ChannelSecret: " . $channelSecret
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($confirmData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        
        if (curl_errno($ch)) {
            throw new Exception('Curl error: ' . curl_error($ch));
        }
        
        curl_close($ch);

        $result = json_decode($response, true);

        if (isset($result['returnCode']) && $result['returnCode'] === '0000') {
            session_unset();
            session_destroy();
            $userDataEncoded = urlencode(json_encode($userData));
            // 交易成功，重定向到成功頁面
            header("Location: https://tibamef2e.com/tid103/g1/donatefinish?userData={$userDataEncoded}");
            exit();
        } else {
            // 交易失敗，重定向到失敗頁面
            header("Location: https://tibamef2e.com/tid103/g1/donation/confirm");
            exit();
        }
    } catch (Exception $e) {
        // 發生錯誤，重定向到失敗頁面
        header("Location: https://tibamef2e.com/tid103/g1/donation/confirm");
        exit();
    }
} else {
    // 缺少交易 ID，重定向到失敗頁面
    header("Location: https://tibamef2e.com/tid103/g1/donation/confirm");
    exit();
}
?>