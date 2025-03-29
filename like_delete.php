<?php
session_start();

// セッションからユーザーIDを取得
$user_id = $_SESSION['user_id'] ?? null;

// ユーザーIDがセッションにない場合、エラーメッセージを表示して終了
if ($user_id === null) {
    echo "Error: User not logged in.";
    exit();  // ログインしていない場合はここで処理を終了
}

include('functions.php');
check_session_id();

// DB接続
$pdo = connect_to_db();

// いいねの取り消し
if (isset($_GET['sender_id']) && isset($_GET['receiver_id'])) {
    $sender_id = $_GET['sender_id'];
    $receiver_id = $_GET['receiver_id'];

    // いいねを取り消すSQL
    $sql = 'DELETE FROM like_table WHERE sender_id = :sender_id AND receiver_id = :receiver_id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':sender_id', $sender_id, PDO::PARAM_INT);
    $stmt->bindValue(':receiver_id', $receiver_id, PDO::PARAM_INT);

    try {
        $stmt->execute();
        echo "Like removed";
    } catch (PDOException $e) {
        echo json_encode(["sql error" => "{$e->getMessage()}"]);
        exit();
    }
}
?>