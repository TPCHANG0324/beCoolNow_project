<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *"); // 允許跨來源請求 (CORS)
header("Access-Control-Allow-Methods: GET");

error_reporting(E_ALL);
ini_set('display_errors', 1);


include('conn.php'); // 請確保此檔能正確連接到資料庫

$method = $_SERVER['REQUEST_METHOD'];

/**
 * 付款方式 payMethod:
 *   0 => '信用卡'
 *   1 => 'Line Pay'
 *
 * 付款狀態 payStatus:
 *   0 => '未付款'
 *   1 => '已付款'
 *
 * 訂單狀態 orderStatus:
 *   0 => '待處理'
 *   1 => '已完成'
 *
 * 送貨方式 shipMethod:
 *   0 => '新竹物流宅配'
 *   1 => '台灣離島郵寄'
 *
 * 送貨狀態 shipStatus:
 *   0 => '未出貨'
 *   1 => '已出貨'
 *
 */

if ($method === 'GET' && isset($_GET['all_orders'])) {
    // 取得所有訂單
    try {
        $sql = "SELECT
                ID, -- 訂單編號
                member_ID, -- 會員編號
                payMethod, -- 付款方式
                payStatus, -- 付款狀態
                orderStatus, -- 訂單狀態
                shipMethod, -- 送貨方式
                shipStatus, -- 送貨狀態
                shippingFee, -- 運費
                buyDate, -- 訂購日期
                total, -- 總金額
                usePoints, -- 折扣點數
                recipientName, -- 收件人姓名
                recipientEmail, -- 收件人信箱
                recipientPhone, -- 收件人手機
                recipientAdress, -- 收件人地址
                orderNotes, -- 訂單備註
                invoiceType -- 發票類型
                FROM G1_Order
                ORDER BY buyDate ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];



        // 轉換 TINYINT 狀態為可讀文字
        foreach ($orders as &$order) {
            // payStatus (0 or 1)
            $order['payMethod'] = ($order['payMethod'] == 1) ? "Line Pay" : "信用卡";

            $order['payStatus'] = ($order['payStatus'] == 1) ? "已付款" : "未付款";

            $order['orderStatus'] = ($order['orderStatus'] == 1) ? "已完成" : "待處理";

            $order['shipMethod'] = ($order['shipMethod'] == 1) ? "台灣離島郵寄" : "新竹物流宅配";

            $order['shipStatus'] = ($order['shipStatus'] == 1) ? "已出貨" : "未出貨";

        }

        // ✅ 確保 API 回傳的數據是字串
error_log("📌 檢查後端轉換後的訂單資料 (應該是字串): " . json_encode($orders, JSON_UNESCAPED_UNICODE));
        echo json_encode([
            "success" => true,
            "orders" => $orders
        ]);
    } catch (Exception $e) {
        echo json_encode([
            "success" => false,
            "error" => $e->getMessage()
        ]);
    }
    exit;
}
else if ($method === 'GET' && isset($_GET['id'])) {
    // 取得單筆訂單 (含訂單明細)

    $order_id = trim($_GET['id']); // 先移除空格
    // error_log("📌 去除空格後的訂單empttttyy ID: " . $order_id);
    if (!ctype_digit($order_id)) { // 確保是純數字
        // error_log("❌ 非數字的訂單nannnnnnn ID: " . $order_id);
        echo json_encode([
            "success" => false,
            "message" => "無效的訂單 ID"
        ]);
        exit;
    }

    $order_id = intval($order_id); // 最後轉換為數字
    // error_log("📌 最終轉換的訂單 ID:fiiiiiiiiiinaaall " . $order_id);


    try {
        $sql = "SELECT * FROM G1_Order WHERE ID = :order_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->execute();

        // error_log("📌 SQL 執行成功，影響行數2222222: " . $stmt->rowCount());

        $order = $stmt->fetch(PDO::FETCH_ASSOC);
        if (empty($order)) {
            // error_log("❌ 訂單不存在，ID: " . $order_id);
            echo json_encode([
                "success" => false,
                "message" => "訂單不存在"
            ]);
            exit;
        }

        // 取得訂單明細
        $sql_detail = "SELECT G1_OrderDetail.*, G1_Product.productName,
                    (G1_OrderDetail.salePrice * G1_OrderDetail.quantity) AS subtotal
               FROM G1_OrderDetail
               JOIN G1_Product ON G1_OrderDetail.Product_ID = G1_Product.ID
               WHERE G1_OrderDetail.Order_ID = :order_id";
        $stmt_detail = $pdo->prepare($sql_detail);
        $stmt_detail->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt_detail->execute();
        $order_details = $stmt_detail->fetchAll(PDO::FETCH_ASSOC);

        // 計算所有商品的總小計
        // $totalSubtotal = array_sum(array_column($order_details, 'subtotal'));
        $totalSubtotal = empty($order_details) ? 0 : array_sum(array_column($order_details, 'subtotal'));


        if (empty($order_details)) {
            // error_log("⚠️ 訂單明細不存在，Order_ID:44444444 " . $order_id);
        }

        echo json_encode([
            "success" => true,
            "order" => array_merge($order, ["subtotal" => $totalSubtotal]), // 新增 subtotal
            "order_details" => $order_details
        ], JSON_UNESCAPED_UNICODE);
    } catch (Exception $e) {
        // error_log("❌ SQL 錯誤: 555555555" . $e->getMessage());
        echo json_encode([
            "success" => false,
            "error" => $e->getMessage()
        ]);
    }
}
?>
