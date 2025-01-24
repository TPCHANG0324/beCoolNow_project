<?php
// 模擬一組假的新聞資料
$fakeNews = [
    [
        "title" => "Breaking News: AI Technology Advances Rapidly",
        "description" => "AI technology has made significant progress in the past year, with major breakthroughs in machine learning.",
        "publishedAt" => "2025-01-23T10:00:00Z",
        "author" => "John Doe",
    ],
    [
        "title" => "Economy Update: Markets See Significant Growth",
        "description" => "Stock markets around the globe are seeing unprecedented growth, driven by technology and innovation.",
        "publishedAt" => "2025-01-22T14:30:00Z",
        "author" => "Jane Smith",
    ],
    [
        "title" => "Sports Highlight: Team Wins Championship",
        "description" => "The underdog team has won the championship in a thrilling match that had fans on the edge of their seats.",
        "publishedAt" => "2025-01-21T18:00:00Z",
        "author" => "Mike Johnson",
    ],
];

// 解決 CORS 問題
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

echo json_encode([
    "status" => "ok",
    "totalResults" => count($fakeNews),
    "articles" => $fakeNews,
]);
