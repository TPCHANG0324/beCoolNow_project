<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json; charset=utf-8');



$register =  json_decode(file_get_contents("php://input"), true);
$account = htmlspecialchars($register['account']); //防止注射攻擊
$password = password_hash($register['password'], PASSWORD_DEFAULT); //密碼加密

//建立連線
include('connect.php');

// 檢查帳號是否已存在
$checkSql = "SELECT COUNT(*) FROM member WHERE Account = ?";
$checkStmt = $pdo->prepare($checkSql);
$checkStmt->execute([$account]);
$accountExists = $checkStmt->fetchColumn();

if ($accountExists) {
    echo json_encode([
        "success" => false,
        "error" => "帳號已被註冊！",
    ]);
    exit;
}


$sql = "INSERT INTO member(Account, PWD, CreateDate) VALUES (?, ?, NOW())";

$statement = $pdo->prepare($sql);  
$statement->bindValue(1, $account);  
$statement->bindValue(2, $password);

// 判斷註冊成功與否
try {  
    // 準備並執行插入操作  
    if ($statement->execute([$account, $password])) {
        echo json_encode([
            "success" => true,
            "message" => "註冊成功！",
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "error" => "新增失敗！",
        ]);
    }
} catch (PDOException $e) {  
    echo json_encode([
        "success" => false,
        "error" => "錯誤信息：" . $e->getMessage(),
    ]);  
} 


?>