<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");


include 'conn.php';  // 連接資料庫

// **檢查請求是否包含商品 ID 和圖片**
if (!isset($_POST["productID"]) || !isset($_FILES["image"]) || $_FILES["image"]["error"] !== UPLOAD_ERR_OK) {
    echo json_encode(["success" => false, "error" => "請提供商品 ID 和圖片"]);
    exit;
}

$productID = intval($_POST["productID"]); // ✅ 確保 `productID` 是整數

// 設定目標資料夾
$uploadDir = __DIR__ . "../../images/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true); // 若不存在，則建立資料夾
}

// 使用原始圖片名稱
$fileName = basename($_FILES["image"]["name"]);
$targetFilePath = $uploadDir . $fileName;


try {
    // **檢查該商品是否存在**
    $stmt = $pdo->prepare("SELECT ID FROM g2.G1_Product WHERE ID = ?");
    $stmt->execute([$productID]);

    if ($stmt->rowCount() === 0) {
        echo json_encode(["success" => false, "error" => "找不到該商品 ID"]);
        exit;
    }

    $targetFilePath = $uploadDir . $fileName;

    if (file_exists($targetFilePath)) {
        echo json_encode(["success" => false, "error" => "此圖片名稱已存在，請更改圖片名稱再上傳"]);
        exit;
    }

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
        // **更新對應商品的 `productPic1`**
        $stmt = $pdo->prepare("UPDATE g2.G1_Product SET productPic1 = ? WHERE ID = ?");
        $stmt->execute([$fileName, $productID]);

        echo json_encode(["success" => true, "imagePath" => $fileName]);
    } else {
        echo json_encode(["success" => false, "error" => "圖片上傳失敗"]);
    }
} catch (PDOException $e) {
    echo json_encode(["success" => false, "error" => "資料庫錯誤: " . $e->getMessage()]);
}
?>
