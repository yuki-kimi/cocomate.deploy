<?php
// セッション開始
session_start();
include('functions.php');
check_session_id();

$pdo = connect_to_db();
$user_id = $_SESSION['user_id'] ?? null;
if ($user_id === null) {
    exit('ユーザーIDが不正です');
}

if (
  !isset($_POST['birthdate']) || $_POST['birthdate'] === '' ||
  !isset($_POST['residence']) || $_POST['residence'] === '' ||
  !isset($_POST['comment']) || $_POST['comment'] === ''
) {
  exit('必要なデータが入力されていません');
}

$birthdate = $_POST['birthdate'];
$birthDate = new DateTime($birthdate);
$currentDate = new DateTime();
$age = $currentDate->diff($birthDate)->y;
$residence = $_POST['residence'];
$comment = $_POST['comment'];
$desired_partnership_array = $_POST['desired_partnership'] ?? [];
$desired_partnership = implode(',', $desired_partnership_array);

// 画像処理
$profile_photo = null;
if (!empty($_FILES['profile_photo']['tmp_name'])) {
  $profile_photo = file_get_contents($_FILES['profile_photo']['tmp_name']);
} else {
  // 既存画像を保持するためにDBから取得
  $sql = 'SELECT profile_photo FROM profile_table WHERE user_id = :user_id';
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
  $stmt->execute();
  $profile_photo = $stmt->fetchColumn();
}

// プロフィールが既に存在しているかチェック
$sql = 'SELECT COUNT(*) FROM profile_table WHERE user_id = :user_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$profile_exists = $stmt->fetchColumn() > 0;

if ($profile_exists) {
    // UPDATE
    $sql = 'UPDATE profile_table 
        SET birthdate = :birthdate, age = :age, residence = :residence, comment = :comment, desired_partnership = :desired_partnership, profile_photo = :profile_photo 
        WHERE user_id = :user_id';
} else {
    // INSERT
    $sql = 'INSERT INTO profile_table (user_id, birthdate, age, residence, comment, desired_partnership, profile_photo)
    VALUES (:user_id, :birthdate, :age, :residence, :comment, :desired_partnership, :profile_photo)';
}

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->bindValue(':birthdate', $birthdate, PDO::PARAM_STR);
$stmt->bindValue(':age', $age, PDO::PARAM_INT);
$stmt->bindValue(':residence', $residence, PDO::PARAM_INT);
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
$stmt->bindValue(':desired_partnership', $desired_partnership, PDO::PARAM_STR);
$stmt->bindValue(':profile_photo', $profile_photo, PDO::PARAM_LOB);

try {
  $stmt->execute();
  header('Location: mypage.php');
  exit();
} catch (PDOException $e) {
  echo json_encode(["sql error" => $e->getMessage()]);
  exit();
}
