<?php
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json; charset=utf-8');

include 'conn.php';

session_start();
session_destroy();

echo json_encode([
    "success" => true,
    "message" => "登出成功！"
]);

?>
