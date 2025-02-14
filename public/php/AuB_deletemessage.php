<?php
include('conn.php'); // 連接到 MySQL

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
 // 取得前端傳來的 ID
 $id = $_GET['id'] ?? null;

 if ($id) {
     try {
         $stmt = $pdo->prepare("DELETE FROM G1_ContactUS WHERE ID = ?");
         $stmt->execute([$id]);

         if ($stmt->rowCount() > 0) {
             echo json_encode(['message' => '刪除成功']);
         } else {
             echo json_encode(['error' => '找不到資料']);
         }
     } catch (Exception $e) {
         echo json_encode(['error' => $e->getMessage()]);
     }
 } else {
     echo json_encode(['error' => '缺少 ID 參數']);
 }
}
?>