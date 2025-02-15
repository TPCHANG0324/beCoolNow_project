<?php

// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Credentials: true');
// header('Content-Type: application/json; charset=utf-8');


// session_start();

// // 檢查是否已登入
// if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
//     echo json_encode([
//         "success" => false,
//         "message" => "驗證失敗，請先登入！"
//     ]);
//     exit;
// }

// $email = $_SESSION['email'];

$sorce = json_decode(file_get_contents('php://input'), true);
$email = $sorce['userEmail'];

include('conn.php');

//需要的欄位再自行增加
$sql = "
    SELECT
        id,
        account as nickname,
        email,
        phoneNumber,
        imagePath as avatar 
        FROM G2_MEMBER WHERE email = ?";
$statement = $pdo->prepare($sql);
$statement->bindValue(1, $email);
$statement->execute();

$data = $statement->fetch(PDO::FETCH_ASSOC);

if ($data) {
    echo json_encode([
        "success" => true,
        "data" => $data
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "找不到會員資料"
    ]);
}
