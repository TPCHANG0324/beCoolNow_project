<?php
// header('Access-Control-Allow-Origin: http://localhost:3000');
// header('Access-Control-Allow-Credentials: true');
// header('Access-Control-Allow-Methods: POST');
// header('Access-Control-Allow-Headers: Content-Type');
// header('Content-Type: application/json; charset=utf-8');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
include('conn.php');



session_start();
$login =  json_decode(file_get_contents("php://input"), true);
$email = htmlspecialchars($login['email']); //防止注射攻擊
$password = $login['password'];

// include('connect.php');


$sql = "SELECT id, password, account, phoneNumber, enterCity FROM G2_MEMBER WHERE email = ?";
$statement = $pdo->prepare($sql);
$statement->bindValue(1, $email);
$statement->execute();

$data = $statement->fetch(PDO::FETCH_ASSOC);


if ($data) {
    $hashedPassword = $data['password'];
    if(password_verify($password, $hashedPassword)){
        $_SESSION['login'] = true;
        $_SESSION['email'] = $email;
        echo json_encode([
            "success" => true,
            "message" => "登入成功！",
            "sessionId" => session_id(),
            "email" => $email,
            "member_ID" => $data['id'],
            "account" => $data['account'],
            "phoneNumber" => $data['phoneNumber'],
            "enterCity" => $data['enterCity']
        ]);
    }else{
        echo json_encode([
            "success" => false,
            "message" => "密碼錯誤，請查明後再試！"
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "查無此帳號密碼，請先註冊後再登入！"
    ]);
}


?>
