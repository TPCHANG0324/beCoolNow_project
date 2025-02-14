<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');

include('conn.php');

ob_end_clean();

try {
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $question = isset($_POST['question']) ? trim($_POST['question']) : '';
    $option1 = isset($_POST['option1']) ? trim($_POST['option1']) : '';
    $option2 = isset($_POST['option2']) ? trim($_POST['option2']) : '';
    $option3 = isset($_POST['option3']) ? trim($_POST['option3']) : '';
    $correctAnswer = isset($_POST['answer']) ? trim($_POST['answer']) : 'A';

    if ( empty($question) || empty($option1) || empty($option2) || empty($option3) || empty($correctAnswer)) {
        echo json_encode(['success' => false, 'message' => '請填寫所有必要欄位']);
        exit;
    }

    $sql = "UPDATE G1_QnA SET question = ?, option1 = ?, option2 = ?, option3 = ?, answer = ? WHERE ID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$question, $option1, $option2, $option3, $correctAnswer, $id]);

    if ($stmt->rowCount() > 0) {
       
        echo json_encode(['success' => true, 'message' => '更新成功', 'id' => $id]);
    } else {
        echo json_encode(['success' => false, 'message' => '沒有資料被更新']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
