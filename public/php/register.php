<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json; charset=utf-8');


$register =  json_decode(file_get_contents("php://input"), true);
$account = htmlspecialchars($register['account']); //防止注射攻擊，暱稱
$email = htmlspecialchars($register['email']); //電郵
$password = password_hash($register['password'], PASSWORD_DEFAULT); //密碼加密

//建立連線
// include('connect.php');
include('conn.php');


// 檢查電郵是否已存在
$checkSql = "SELECT COUNT(*) FROM G2_MEMBER WHERE email = ?";
$checkStmt = $pdo->prepare($checkSql);
$checkStmt->bindValue(1, $email);
$checkStmt->execute();
$emailExists = $checkStmt->fetchColumn();

if ($emailExists) {
    echo json_encode([
        "success" => false,
        "error" => "帳號已被註冊！",
    ]);
    exit;
}


$sql = "INSERT INTO G2_MEMBER(account, email, password, createTime) VALUES (?, ?, ?, NOW())";

$statement = $pdo->prepare($sql);
$statement->bindValue(1, $account);
$statement->bindValue(2, $email);
$statement->bindValue(3, $password);

// 判斷註冊成功與否
try {
    // 準備並執行插入操作
    if ($statement->execute()) {
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

$pdo = null;

?>
