<?php
session_start();

$userData = $_SESSION['userData'] ?? null;

if ($userData) {
    echo json_encode(["success" => true, "data" => $userData]);
} else {
    echo json_encode(["success" => false, "message" => "No user data found"]);
}

session_unset();
session_destroy();
