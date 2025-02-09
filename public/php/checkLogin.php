<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json; charset=utf-8');

session_start();

if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    echo json_encode([
        "success" => true,
        "email" => $_SESSION['email']
    ]);
} else {
    echo json_encode([
        "success" => false
    ]);
}


?>