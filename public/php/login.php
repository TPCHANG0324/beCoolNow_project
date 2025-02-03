<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json; charset=utf-8');

$login =  json_decode(file_get_contents("php://input"), true);
$account = htmlspecialchars($login['account']); //防止注射攻擊
$password = $login['password'];

include('connect.php');

$sql = "SELECT PWD FROM member WHERE Account = ?";  
$statement = $pdo->prepare($sql);  
$statement->bindValue(1, $account);  
$statement->execute();  

$data = $statement->fetch(PDO::FETCH_ASSOC);


if ($data) {
    $hashedPassword = $data['PWD'];
    if(password_verify($password, $hashedPassword)){
        session_start();
        $_SESSION['login'] = true;
        $_SESSION['acount'] = $account;
        echo json_encode([
            "success" => true,
            "message" => "登入成功！",
            "sessionId" => session_id(),
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