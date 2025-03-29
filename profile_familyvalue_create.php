<?php

// セッション開始
session_start();
include('functions.php');
check_session_id();

// データベース接続
$pdo = connect_to_db(); 

// POSTデータを受け取る
$user_id = $_SESSION['user_id'];
$family_comments = [
    'family_comment_01' => $_POST['family_comment_01'] ?? null,
    'family_comment_02' => $_POST['family_comment_02'] ?? null,
    'family_comment_03' => $_POST['family_comment_03'] ?? null,
    'family_comment_04' => $_POST['family_comment_04'] ?? null,
    'family_comment_05' => $_POST['family_comment_05'] ?? null,
    'family_comment_06' => $_POST['family_comment_06'] ?? null,
    'family_comment_07' => $_POST['family_comment_07'] ?? null,
    'family_comment_08' => $_POST['family_comment_08'] ?? null,
    'family_comment_09' => $_POST['family_comment_09'] ?? null,
    'family_comment_10' => $_POST['family_comment_10'] ?? null,
];

// `user_id` のデータがあるか確認
$sql_check = 'SELECT COUNT(*) FROM profile_familyvalue_table WHERE user_id = :user_id';
$stmt_check = $pdo->prepare($sql_check);
$stmt_check->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt_check->execute();
$record_exists = $stmt_check->fetchColumn();

try {
    if ($record_exists > 0) {
        // 既存データを取得
        $sql_select = 'SELECT * FROM profile_familyvalue_table WHERE user_id = :user_id';
        $stmt_select = $pdo->prepare($sql_select);
        $stmt_select->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt_select->execute();
        $existing_data = $stmt_select->fetch(PDO::FETCH_ASSOC);
    
        // POSTが空の項目は既存のデータで上書きする
        foreach ($family_comments as $key => $value) {
            if ($value === null || trim($value) === '') {
                $family_comments[$key] = $existing_data[$key]; // 上書き
            }
        }
    
        // UPDATE文
        $sql = 'UPDATE profile_familyvalue_table SET 
            family_comment_01 = :family_comment_01,
            family_comment_02 = :family_comment_02,
            family_comment_03 = :family_comment_03,
            family_comment_04 = :family_comment_04,
            family_comment_05 = :family_comment_05,
            family_comment_06 = :family_comment_06,
            family_comment_07 = :family_comment_07,
            family_comment_08 = :family_comment_08,
            family_comment_09 = :family_comment_09,
            family_comment_10 = :family_comment_10
            WHERE user_id = :user_id';
    } else {
        // 新規登録（INSERT）
        $sql = 'INSERT INTO profile_familyvalue_table (
            user_id, family_comment_01, family_comment_02, family_comment_03, family_comment_04,
            family_comment_05, family_comment_06, family_comment_07, family_comment_08,
            family_comment_09, family_comment_10, created_at) 
            VALUES (
            :user_id, :family_comment_01, :family_comment_02, :family_comment_03, :family_comment_04,
            :family_comment_05, :family_comment_06, :family_comment_07, :family_comment_08,
            :family_comment_09, :family_comment_10, NOW())';
    }


    // SQL準備
    $stmt = $pdo->prepare($sql);
    
    // パラメータをバインド
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    foreach ($family_comments as $key => $value) {
        $stmt->bindValue(":$key", $value, PDO::PARAM_STR);
    }

    // SQL実行
    $status = $stmt->execute();

    if (!$status) {
        throw new Exception("SQL実行に失敗しました");
    }

    // 正常終了 → リダイレクト
    header('Location: profile_familyvalue_read.php');
    exit();

} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
    exit();
}
