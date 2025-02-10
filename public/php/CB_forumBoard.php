<?php
include "connect.php";

$member = '123';

$sql = "  
        INSERT INTO G1_City (id, CityPic1, CityPic2, CityPic3)  
        VALUES (88, 'ygf6', '7d89', '2d22')  
";

$test = $pdo->exec($sql);
if ($test > 0) {
    echo 'success';
} else {
    echo 'error';
}

// $stmt = $pdo->prepare($sql);
// $stmt->bindValue(":usr", $member['username']);
// $stmt->bindValue(":pwd", $member['password']);
// $stmt->execute();



// $member = $stmt->fetch();

// $member["avatarBase64"] = base64_encode($member["avatar"]);
// $member["avatar"] = null;
// $member[5] = null;

// echo json_encode($member);

?>