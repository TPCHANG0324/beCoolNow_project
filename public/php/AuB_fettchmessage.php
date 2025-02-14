<?php
include('conn.php'); // 確保有連接到 MySQL

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

try {
    $stmt = $pdo->query("SELECT * FROM G1_ContactUS ORDER BY contactDate DESC");
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($contacts);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
