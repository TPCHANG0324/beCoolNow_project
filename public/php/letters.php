<?php
// header('Content-Type: application/json');
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// 記錄接收到的數據
// file_put_contents('debug.log', print_r([
//     'POST_DATA' => file_get_contents('php://input'),
//     'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'],
//     'CONTENT_TYPE' => $_SERVER['CONTENT_TYPE'] ?? 'not set'
// ], true), FILE_APPEND);

// 引入數據庫連接文件
include('conn.php');

// 如果是 OPTIONS 請求，直接返回
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// 根據請求方法處理不同的操作
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // 獲取信件列表
        try {
            $stmt = $pdo->prepare("
                SELECT poster, mailContents, postTime 
                FROM G1_EarthMail 
                ORDER BY postTime DESC
            ");
            
            $stmt->execute();
            $letters = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo json_encode([
                'success' => true,
                'letters' => $letters,
                'total' => count($letters)
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        break;

    case 'POST':
        // 添加新信件
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($data['poster']) || !isset($data['mailContents'])) {
                throw new Exception('Missing required fields');
            }
    
            $stmt = $pdo->prepare("
                INSERT INTO G1_EarthMail (poster, mailContents, postTime)
                VALUES (:poster, :mailContents, NOW())
            ");
    
            $stmt->execute([
                ':poster' => $data['poster'],
                ':mailContents' => $data['mailContents'],
            ]);
    
            $id = $pdo->lastInsertId();
    
            echo json_encode([
                'success' => true,
                'message' => 'Letter submitted successfully',
                'id' => $id
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        break;

    default:
        echo json_encode([
            'success' => false,
            'message' => 'Method not allowed'
        ]);
        break;
}
?>