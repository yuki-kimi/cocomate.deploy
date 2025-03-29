<?php
session_start();
header('Content-Type: application/json');

$user_id = $_SESSION['user_id'] ?? null;
$receiver_id = $_POST['receiver_id'] ?? null;

if (!$user_id || !$receiver_id) {
    echo json_encode(['status' => 'error']);
    exit;
}

include('functions.php');
$pdo = connect_to_db();

$sql = 'SELECT COUNT(*) FROM like_table WHERE sender_id = :sender AND receiver_id = :receiver';
$stmt = $pdo->prepare($sql);
$stmt->execute([':sender' => $user_id, ':receiver' => $receiver_id]);
$count = $stmt->fetchColumn();

if ($count > 0) {
    $sql = 'DELETE FROM like_table WHERE sender_id = :sender AND receiver_id = :receiver';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':sender' => $user_id, ':receiver' => $receiver_id]);
    echo json_encode(['status' => 'unliked']);
} else {
    $sql = 'INSERT INTO like_table (sender_id, receiver_id) VALUES (:sender, :receiver)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':sender' => $user_id, ':receiver' => $receiver_id]);
    echo json_encode(['status' => 'liked']);
}
exit;


