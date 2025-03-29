<?php
session_start();  // セッション開始
include('functions.php');


// POSTパラメータが存在し、空でないことを確認
if (
  !isset($_POST['family_name']) || $_POST['family_name'] === '' ||
  !isset($_POST['first_name']) || $_POST['first_name'] === '' ||
  !isset($_POST['email_address']) || $_POST['email_address'] === '' ||
  !isset($_POST['password']) || $_POST['password'] === ''
) {
  exit('paramError');
}

// POSTされたデータを変数に格納
$family_name = $_POST['family_name'];
$first_name = $_POST['first_name'];
$email_address = $_POST['email_address'];
$password = $_POST['password'];
$is_admin = 0;  // 例: デフォルトで一般ユーザーに設定

//DB接続
$pdo = connect_to_db();

// SQLクエリ
$sql = 'INSERT INTO profile_initial_table(user_id, family_name, first_name, email_address, is_admin, password, created_at, deleted_at) 
         VALUES(NULL, :family_name, :first_name, :email_address, :is_admin, :password, now(), NULL)';

// SQL実行の準備
$stmt = $pdo->prepare($sql);

// 変数をバインド
$stmt->bindValue(':family_name', $family_name, PDO::PARAM_STR);
$stmt->bindValue(':first_name', $first_name, PDO::PARAM_STR);
$stmt->bindValue(':email_address', $email_address, PDO::PARAM_STR);
$stmt->bindValue(':is_admin', $is_admin, PDO::PARAM_INT);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);

try {
  // SQLの実行
  $status = $stmt->execute();
  
  // SQL実行が成功した場合の処理
  if ($status) {
    // 登録した後に、セッションに新しく登録したユーザー情報を保存して、ログイン状態にする
    $_SESSION['user_id'] = $pdo->lastInsertId();  // 挿入されたレコードのIDをセッションにセット
    $_SESSION['is_logged_in'] = true;  // ログイン状態を記録

    // 成功した場合リダイレクト
    header("Location: login.php");  // 成功した場合リダイレクト
    exit();
  } else {
    echo "データベースへの挿入に失敗しました。";  // SQL実行失敗時のエラーメッセージ
  }
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

?>
<!-- 
<?php

session_start();
include('functions.php');

// POSTパラメータが存在し、空でないことを確認
if (
  !isset($_POST['family_name']) || $_POST['family_name'] === '' ||
  !isset($_POST['first_name']) || $_POST['first_name'] === '' ||
  !isset($_POST['email_address']) || $_POST['email_address'] === '' ||
  !isset($_POST['password']) || $_POST['password'] === ''
) {
  exit('paramError');
}

// POSTされたデータを変数に格納
$family_name = $_POST['family_name'];
$first_name = $_POST['first_name'];
$email_address = $_POST['email_address'];
$password = $_POST['password'];
$is_admin = 0;  // 例: デフォルトで一般ユーザーに設定

// DB接続
$pdo = connect_to_db();

// SQLクエリ (profile_initial_tableにデータを挿入)
$sql = 'INSERT INTO profile_initial_table(user_id, family_name, first_name, email_address, is_admin, password, created_at, deleted_at) 
        VALUES(NULL, :family_name, :first_name, :email_address, :is_admin, :password, now(), NULL)';

// SQL実行の準備
$stmt = $pdo->prepare($sql);

// 変数をバインド
$stmt->bindValue(':family_name', $family_name, PDO::PARAM_STR);
$stmt->bindValue(':first_name', $first_name, PDO::PARAM_STR);
$stmt->bindValue(':email_address', $email_address, PDO::PARAM_STR);
$stmt->bindValue(':is_admin', $is_admin, PDO::PARAM_INT);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);

try {
  // SQLの実行
  $status = $stmt->execute();

  // 成功した場合、挿入されたuser_idを取得
  $user_id = $pdo->lastInsertId(); // 最後に挿入されたIDを取得
  if (!$user_id) {
    throw new Exception("user_idの取得に失敗しました");
  }


  // 次に、profile_familyvalue_tableに空のコメントを挿入
  $sql2 = 'INSERT INTO profile_familyvalue_table(id, user_id, family_comment_01, family_comment_02, family_comment_03, family_comment_04, family_comment_05, family_comment_06, family_comment_07, family_comment_08, family_comment_09, family_comment_10, created_at) 
           VALUES(NULL, :user_id, "", "", "", "", "", "", "", "", "", "", now())';

  // SQL実行の準備
  $stmt2 = $pdo->prepare($sql2);
  $stmt2->bindValue(':user_id', $user_id, PDO::PARAM_INT);

  // profile_familyvalue_tableへの挿入実行
  $status2 = $stmt2->execute();

  // profile_familyvalue_tableへの挿入成功確認
  if ($status2) {
    // 成功した場合リダイレクト
    header("Location: login.php");
    exit();
  } else {
    throw new Exception("profile_familyvalue_tableへの挿入に失敗しました");
  }

} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
} catch (Exception $e) {
  echo "エラー: " . $e->getMessage();
  exit();
}

?> -->
