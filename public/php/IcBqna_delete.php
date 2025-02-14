<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');

include('conn.php');

try {
    // 取得傳入的 id 參數
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    
    if (empty($id)) {
        echo json_encode(['success' => false, 'message' => '請提供有效的ID']);
        exit;
    }

    // 執行刪除資料庫記錄的 SQL 指令
    $sql = "DELETE FROM G1_QnA WHERE ID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    // 檢查是否有資料被刪除
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => '刪除成功']);
    } else {
        echo json_encode(['success' => false, 'message' => '刪除失敗，可能沒有該ID的資料']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
