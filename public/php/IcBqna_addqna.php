<?php
// IcBqna_addArticle.php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');

include('connect.php');

try {
    // 取得 POST 文字資料
    $question = isset($_POST['question']) ? trim($_POST['question']) : '';
    $option1 = isset($_POST['option1']) ? trim($_POST['option1']) : '';
    $option2 = isset($_POST['option2']) ? trim($_POST['option2']) : '';
    $option3 = isset($_POST['option3']) ? trim($_POST['option3']) : '';
    $correctAnswer = isset($_POST['correctAnswer']) ? trim($_POST['correctAnswer']) : 'A'; // 預設 A 避免錯誤
    

    // 檢查必要欄位
    // if (empty($question) || empty($option1) || empty($option2) || empty($option3)) {
    //     echo json_encode([
    //         'success' => false,
    //         'message' => '請填寫所有必要欄位'
    //     ]);
    //     exit;
    // }
    // insert data into G1_QnA table
    $sql = "INSERT INTO G1_QnA (question, option1, option2, option3, answer) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$question, $option1, $option2, $option3, $correctAnswer]);

    echo json_encode([
        'question' => $question,
        'success' => true,
        'message' => '文章新增成功'
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
