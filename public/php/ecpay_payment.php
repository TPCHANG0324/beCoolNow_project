<?php
// var_dump($_GET);
// ✅ 綠界 API 串接，導向綠界付款頁面


// ✅ 開啟錯誤回報（開發用）
// error_reporting(E_ALL);
// ini_set('display_errors', 1);


header("Content-Type: text/html; charset=utf-8");

include('conn.php'); // ✅ 確保有資料庫連線



// ✅ 確保 SDK 存在，避免 PHP 找不到檔案
$ecpaySdkPath = __DIR__ . "/ECPay.Payment.Integration.php";
if (!file_exists($ecpaySdkPath)) {
    die("❌ 找不到 ECPay SDK，請確保 `ECPay.Payment.Integration.php` 存在！");
}
require_once $ecpaySdkPath;

try {
    // ✅ 檢查是否有 `Order_ID` 參數
    if (!isset($_GET["Order_ID"])) {
        throw new Exception("❌ 無效的訂單編號");
    }

    // ✅ 獲取 `Order_ID`
    $orderID = $_GET["Order_ID"];
    // error_log("📥 接收到的 Order_ID: " . $orderID);

    // ✅ 取得訂單資訊（確認資料表欄位是否正確）
    $stmt = $pdo->prepare("SELECT * FROM G1_Order WHERE ID = ?");
    $stmt->execute([$orderID]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);


    if (!$order) {
        throw new Exception("❌ 訂單不存在，查無 ID：" . $orderID);
    }

    // error_log("✅ 訂單資訊：" . json_encode($order));




    // ✅ 綠界支付初始化
    $payment = new ECPay_AllInOne();

    // ✅ 設定綠界金流測試參數 (測試環境)
    $payment->ServiceURL = "https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5";
    $payment->HashKey = "5294y06JbISpM5x9";
    $payment->HashIV = "v77hoKGq4kWxNNIS";
    $payment->MerchantID = "2000132";

    // ✅ 設定訂單資訊
    $payment->Send['ReturnURL'] = "https://tid103/g1/payment_callback.php"; // ✅ 綠界回傳付款結果
    $payment->Send['ClientBackURL'] = "https://tid103/g1/shop_finish"; // ✅ 使用者付款完成後返回頁面
    $payment->Send['OrderResultURL'] = "https://tid103/g1/shop_finish"; // ✅ 付款完成後跳轉
    $payment->Send['MerchantTradeNo'] = "Order" . $orderID; // ✅ 訂單號 (請確保不重複)
    $payment->Send['MerchantTradeDate'] = date("Y/m/d H:i:s"); // ✅ 交易日期
    $payment->Send['TotalAmount'] = (int)$order["total"]; // ✅ 總金額
    $payment->Send['TradeDesc'] = "購物付款";
    $payment->Send['ChoosePayment'] = ECPay_PaymentMethod::Credit; // ✅ 信用卡付款

    // ✅ 初始化 `Items` 陣列，避免錯誤
    $payment->Send['Items'] = [];

    // ✅ 取得商品明細 (請確認你的資料表名稱是否正確)
    $stmt = $pdo->prepare("SELECT d.*, p.productName
                           FROM G1_OrderDetail d
                           JOIN G1_Product p ON d.product_id = p.ID
                           WHERE d.Order_ID = ?");
    $stmt->execute([$orderID]);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$items) {
        throw new Exception("❌ 訂單明細不存在，無法處理付款");
    }

    foreach ($items as $item) {
        array_push($payment->Send['Items'], [
            'Name' => $item["productName"], // JOIN 取得商品名稱
            'Price' => (int)$item["price"],
            'Currency' => "TWD",
            'Quantity' => (int)$item["quantity"],
            'URL' => ""
        ]);
    }


    // ✅ 產生綠界付款頁面
    $paymentForm = $payment->CheckOutString(); // ✅ 產生 HTML

    // ✅ 檢查是否有資料
    if (empty($paymentForm)) {
        die("❌ 錯誤：`$paymentForm` 為空，請檢查 ECPay SDK 設定！");
    }
    // ✅ 紀錄表單內容（開發用）
    error_log("✅ ECPay 表單內容：" . $paymentForm);


    // ✅ 讓表單自動提交
    // ✅ 輸出 HTML，確保表單自動提交
    echo "<!DOCTYPE html>
    <html>
    <head>
        <meta charset='utf-8'>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                console.log('🚀 DOM 內容已載入，開始尋找表單...');
                var form = document.getElementById('__ecpayForm');
                if (form) {
                    console.log('✅ 找到表單，3 秒後自動提交...');
                    setTimeout(() => {
                        form.submit();
                    }, 3000);
                } else {
                    console.error('❌ 找不到表單，請檢查 PHP 是否正確輸出 `form`！');
                }
            });
        </script>
    </head>
    <body>
    " . $paymentForm . "
    </body>
    </html>";

    // ✅ 產生綠界付款頁面
    // $paymentForm = $payment->CheckOutString(); // ✅ 產生 HTML
    // echo $paymentForm;
    // exit();

} catch (Exception $e) {
    // error_log("❌ 錯誤：" . $e->getMessage());
    echo "❌ 錯誤：" . $e->getMessage();
}
?>
