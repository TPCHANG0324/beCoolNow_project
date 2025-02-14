<?php
// 完全禁用輸出緩衝
while (ob_get_level()) {
    ob_end_clean();
}

// 設置錯誤報告
ini_set('display_errors', 0);
error_reporting(E_ALL);

// 設置跨域請求頭
// header('Access-Control-Allow-Origin: http://localhost:5173'); 
// header('Access-Control-Allow-Credentials: true');
// header('Access-Control-Allow-Methods: POST, OPTIONS');
// header('Access-Control-Allow-Headers: Content-Type');
// header('Content-Type: application/json; charset=utf-8');

include('conn.php');

// 錯誤日誌函數
function logError($message, $data = null) {
    $logMessage = date('Y-m-d H:i:s') . " - " . $message;
    if ($data !== null) {
        $logMessage .= " - Data: " . print_r($data, true);
    }
    error_log($logMessage . "\n", 3, "user_update_errors.log");
}

try {
    // session_start();
    // logError("Session 狀態", $_SESSION);

    if (!isset($_POST['email'])) {
        throw new Exception('未登入狀態');
    }

    $email = $_POST['email'];
    logError("使用者 email: " . $email);

    // require_once('connect.php');

    // 處理手機號碼更新
    if (isset($_POST['phone'])) {
        $phone = trim($_POST['phone']);
        logError("接收到的手機號碼: " . $phone);

        if (!preg_match('/^09\d{8}$/', $phone)) {
            throw new Exception('手機號碼格式不正確');
        }

        // 檢查手機號碼是否已被使用
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM G2_MEMBER WHERE phoneNumber = ? AND email != ?");
        $stmt->execute([$phone, $email]);
        
        if ($stmt->fetchColumn() > 0) {
            throw new Exception('此手機號碼已被使用');
        }

        // 更新手機號碼
        $stmt = $pdo->prepare("UPDATE G2_MEMBER SET phoneNumber = ? WHERE email = ?");
        $result = $stmt->execute([$phone, $email]);

        if (!$result) {
            throw new Exception('手機號碼更新失敗');
        }

        echo json_encode([
            'success' => true,
            'message' => '手機號碼更新成功'
        ]);
    }
    // 處理暱稱更新 (對應到 account 欄位)
    else if (isset($_POST['nickname'])) {
        $account = trim($_POST['nickname']);
        logError("接收到的暱稱: " . $account);

        // 檢查暱稱是否為空
        if (empty($account)) {
            throw new Exception('暱稱不能為空');
        }

        // 檢查暱稱長度（可依需求調整）
        if (mb_strlen($account, 'UTF-8') > 20) {
            throw new Exception('暱稱長度不能超過20個字元');
        }

        // 更新暱稱 (使用 account 欄位)
        $stmt = $pdo->prepare("UPDATE G2_MEMBER SET account = ? WHERE email = ?");
        $result = $stmt->execute([$account, $email]);

        if (!$result) {
            throw new Exception('暱稱更新失敗');
        }

        echo json_encode([
            'success' => true,
            'message' => '暱稱更新成功'
        ]);
    }
    else {
        throw new Exception('未收到更新資料');
    }

} catch (PDOException $e) {
    logError("PDO 錯誤", [
        'message' => $e->getMessage(),
        'code' => $e->getCode()
    ]);
    echo json_encode([
        'success' => false,
        'message' => '資料庫連接錯誤，請稍後再試',
        'debug' => [
            'error' => $e->getMessage(),
            'code' => $e->getCode()
        ]
    ]);
} catch (Exception $e) {
    logError("一般錯誤", [
        'message' => $e->getMessage()
    ]);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>