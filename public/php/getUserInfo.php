<?php

// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Credentials: true');
// header('Content-Type: application/json; charset=utf-8');

// session_start();

// 檢查是否已登入
// if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
//     echo json_encode([
//         "success" => false,
//         "message" => "驗證失敗，請先登入！"
//     ]);
//     exit;
// }
include('conn.php');

// $email = $_SESSION['email'];
$data = json_decode(file_get_contents('php://input'), true);
$email=$data['userEmail'];

// 查詢會員資料，並將 account 作為 name 與 nickname 返回
$sql = "
    SELECT 
        id,
        account as name,
        account as nickname,
        email,
        phoneNumber,
        imagePath as avatar 
    FROM G2_MEMBER 
    WHERE email = ?";

$statement = $pdo->prepare($sql);
$statement->bindValue(1, $email);
$statement->execute();

$data = $statement->fetch(PDO::FETCH_ASSOC);

if ($data) {
    // 將資料中的 phoneNumber 改成 phone，再回傳給前端
    echo json_encode([
        "success" => true,
        "data" => [
            "id"       => $data['id'],
            "name"     => $data['name'],
            "nickname" => $data['nickname'],
            "email"    => $data['email'],
            "phone"    => $data['phoneNumber'],  // 這裡將 phoneNumber 改名為 phone
            "avatar"   => $data['avatar']
        ]
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "找不到會員資料"
    ]);
}

?>