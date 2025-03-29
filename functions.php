<?php

function connect_to_db(){
    $dbn = 'mysql:dbname=profile_php_db;charset=utf8mb4;port=3306;host=localhost';
    $user = 'root';
    $pwd = '';
    
    try {
        return new PDO($dbn, $user, $pwd);
    } catch (PDOException $e) {
        echo json_encode(["db error" => "{$e->getMessage()}"]);
        exit();
    }
}

// ログイン状態のチェック関数
function check_session_id() {
    if (!isset($_SESSION["user_id"])) {
        // セッションに user_id が設定されていない場合、ログインページにリダイレクト
        header('Location: login.php');
        exit();
    }

    // セッションが開始されている場合、セッションIDを再生成して安全性を保つ
    session_regenerate_id(true);
}

// ユーザーIDをセッションに設定
function set_user_id_in_session($user_id) {
    $_SESSION['user_id'] = $user_id; // セッションにuser_idを保存
}

?>