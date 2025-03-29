<?php
session_start();
include("functions.php");

// var_dump($_POST);
// exit();

// データ受け取り

$email_address = $_POST ["email_address"];
$password = $_POST ["password"];


// DB接続
$pdo = connect_to_db();

// SQL実行
// email_address，password，deleted_atの3項目全ての条件満たすデータを抽出する．
$sql = 'SELECT * FROM profile_initial_table WHERE email_address=:email_address AND password=:password AND deleted_at IS NULL';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':email_address', $email_address, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$user = $stmt->fetch(PDO::FETCH_ASSOC);

// var_dump($user);
// exit();

// ユーザ有無で条件分岐
if (!$user) {
    echo "<p>ログイン情報に誤りがあります</p>";
    echo "<a href=index.php>ログインページに戻る</a>";
    exit();
  } else {
    $_SESSION = array();
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['session_id'] = session_id();
    $_SESSION['is_admin'] = $user['is_admin'];
    $_SESSION['email_address'] = $user['email_address'];
    $_SESSION['first_name'] = $user['first_name'];
    header("Location:profile_read.php");
    exit();
  }
  ?>
