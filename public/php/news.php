<?php

header('Access-Control-Allow-Origin: *'); //解決 cors
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');


$apiKey = "c37e23185827432d8fd46365f1de40be";

// 獲取前端傳遞的參數
$query = isset($_GET['query']) ? $_GET['query'] : '';
$from = isset($_GET['from']) ? $_GET['from'] : '';
$to = isset($_GET['to']) ? $_GET['to'] : '';

$url = "https://newsapi.org/v2/everything?q=" . $query . "&from=" . $from . "&to=" . $to . "&sortBy=popularity&apiKey=" . $apiKey;

// $url = "https://newsapi.org/v2/everything?q='全球%氣候'&from=2024-12-31&to=2025-01-28&sortBy=popularity&apiKey=". $apiKey;



// 使用 cURL 發送請求到 NewsAPI
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

// 添加 User-Agent 標頭
curl_setopt($ch, CURLOPT_USERAGENT, 'MyNewsApp/1.0');

$headers = [
    'User-Agent: MyNewsApp/1.0',
    'Accept: application/json'
];
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);

if(curl_errno($ch)){
    echo json_encode(['error' => curl_error($ch)]);
} else {
    echo $response;
}

curl_close($ch);

?>