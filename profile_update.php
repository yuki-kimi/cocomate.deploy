<?php

session_start();
include('functions.php');
check_session_id();
// var_dump($_POST['id']);
// exit();

if (
    !isset($_POST['id']) || $_POST['id'] === '' ||
    !isset($_POST['comment']) || $_POST['comment'] === '' ||
    !isset($_FILES['profile_photo']) || $_FILES['profile_photo'] === ''
  ) {
    exit('paramError');
  }
  
  $comment = $_POST['comment'];
  $profile_photo = $_FILES['profile_photo'];
  $id = $_POST['id'];


//DB接続
$pdo = connect_to_db();


// アップロードされたファイルの内容を取得
$content = file_get_contents($_FILES['profile_photo']['tmp_name']);

$sql = 'UPDATE profile_table SET comment=:comment, profile_photo=:profile_photo WHERE id=:id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
$stmt->bindValue(':profile_photo', $content, PDO::PARAM_LOB);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);

// echo "SQL: " . $sql . "\n";
// var_dump($todo);
// var_dump($deadline);
// var_dump($id);
// exit();

// var_dump($stmt);
// exit();

try {
  $status = $stmt->execute();
//   var_dump($status);
//   exit();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

header('Location:profile_read.php');
exit();
?>