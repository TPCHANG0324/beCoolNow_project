<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

include('conn.php'); // 連接資料庫

try {
    // **確保前端有傳來商品資訊**
    if (!isset($_POST['productName'], $_POST['price'], $_POST['salePrice'], $_POST['inventory'], $_POST['status'])) {
        echo json_encode(["success" => false, "error" => "❌ 缺少必要的欄位"]);
        exit;
    }

    $productName = $_POST['productName'];
    $price = $_POST['price'];
    $salePrice = $_POST['salePrice'];
    $inventory = $_POST['inventory'];
    $status = isset($_POST['status']) ? ($_POST['status'] === "goOff" ? 1 : 0) : 0; // ✅ `"goTop"` 轉 `1`，`"goOff"` 轉 `0`
    $saleCount = 0; // ✅ 新增商品時，`saleCount` 預設為 `0`

    // 處理圖片上傳
    $imagePath = null;
    $uploadDir = __DIR__ . "/../images/"; // **正確的目錄**

    // **確保目錄存在**
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (!empty($_FILES["image"]["name"])) {
        $fileName = basename($_FILES["image"]["name"]);
        $targetFilePath = $uploadDir . $fileName;

        // 檢查 `tmp_name` 是否存在
        if (!file_exists($_FILES["image"]["tmp_name"])) {
            echo json_encode(["success" => false, "error" => "❌ 圖片 `tmp_name` 不存在"]);
            exit;
        }

        // 檢查目標目錄是否可寫入
        if (!is_writable($uploadDir)) {
            echo json_encode(["success" => false, "error" => "❌ 目標目錄無法寫入"]);
            exit;
        }

         // 檢查是否已有相同檔名的圖片
         if (file_exists($targetFilePath)) {
            echo json_encode(["success" => false, "error" => "❌ 圖片已存在，請重新命名後再上傳"]);
            exit;
        }

        // 移動上傳的檔案
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
            $imagePath = $fileName; // 只存檔名
        } else {
            echo json_encode(["success" => false, "error" => "❌ move_uploaded_file() 失敗"]);
            exit;
        }
    }

    // 寫入資料庫
    $stmt = $pdo->prepare("INSERT INTO G1_Product (productName, price, salePrice, saleCount , inventory, status, productPic1)
                           VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$productName, $price, $salePrice, $saleCount, $inventory, $status, $imagePath]);

    $newID = $pdo->lastInsertId();
    echo json_encode(["success" => true, "newID" => $newID, "imagePath" => $imagePath]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "error" => "❌ SQL 錯誤：" . $e->getMessage()]);
}
?>
