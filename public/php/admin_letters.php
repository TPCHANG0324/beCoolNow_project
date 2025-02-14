<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        try {
            // 獲取分頁參數
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
            $offset = ($page - 1) * $limit;

            // 獲取總數
            $countStmt = $pdo->query("SELECT COUNT(*) FROM G1_EarthMail");
            $total = $countStmt->fetchColumn();

            // 獲取分頁數據
            $stmt = $pdo->prepare("
                SELECT id, poster, mailContents, postTime 
                FROM G1_EarthMail 
                ORDER BY postTime DESC
                LIMIT :limit OFFSET :offset
            ");
            
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            
            $letters = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo json_encode([
                'success' => true,
                'letters' => $letters,
                'total' => $total,
                'currentPage' => $page,
                'totalPages' => ceil($total / $limit)
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        break;

    case 'DELETE':
        try {
            // 從 URL 獲取 ID
            $id = basename($_SERVER['REQUEST_URI']);
            
            $stmt = $pdo->prepare("DELETE FROM G1_EarthMail WHERE id = :id");
            $stmt->execute([':id' => $id]);
            
            if ($stmt->rowCount() > 0) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Letter deleted successfully'
                ]);
            } else {
                throw new Exception('Letter not found');
            }
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