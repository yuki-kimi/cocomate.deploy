<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include('functions.php'); 
$pdo = connect_to_db();

// データ取得
$sketch = $_SESSION['sketch'] ?? [];
$tags = $_SESSION['selected_tags'] ?? [];
$user_id = $_SESSION['user_id'] ?? null;

if (count($sketch) !== 10 || empty($tags)) {
    echo "保存に必要なデータが不足しています。";
    exit;
}

// === familyvalueテーブルに保存 ===
$sql1 = "INSERT INTO profile_familyvalue_table (
    user_id,
    family_comment_01, family_comment_02, family_comment_03, family_comment_04, family_comment_05,
    family_comment_06, family_comment_07, family_comment_08, family_comment_09, family_comment_10,
    created_at
) VALUES (
    :user_id,
    :fc1, :fc2, :fc3, :fc4, :fc5, :fc6, :fc7, :fc8, :fc9, :fc10,
    NOW()
)";
$stmt1 = $pdo->prepare($sql1);
$stmt1->execute([
    ':user_id' => $user_id,
    ':fc1' => $sketch[0]['answer'],
    ':fc2' => $sketch[1]['answer'],
    ':fc3' => $sketch[2]['answer'],
    ':fc4' => $sketch[3]['answer'],
    ':fc5' => $sketch[4]['answer'],
    ':fc6' => $sketch[5]['answer'],
    ':fc7' => $sketch[6]['answer'],
    ':fc8' => $sketch[7]['answer'],
    ':fc9' => $sketch[8]['answer'],
    ':fc10'=> $sketch[9]['answer'],
]);

// === タグテーブルに保存（nullではなく""で埋める） ===
$sql2 = "INSERT INTO sketch_tags (
    user_id, tag_01, tag_02, tag_03, tag_04, tag_05, tag_06, tag_07, created_at
) VALUES (
    :user_id, :t1, :t2, :t3, :t4, :t5, :t6, :t7, NOW()
)";

$tagValues = array_pad($tags, 7, ""); // 空文字で埋める

$stmt2 = $pdo->prepare($sql2);
$stmt2->execute([
    ':user_id' => $user_id,
    ':t1' => $tagValues[0],
    ':t2' => $tagValues[1],
    ':t3' => $tagValues[2],
    ':t4' => $tagValues[3],
    ':t5' => $tagValues[4],
    ':t6' => $tagValues[5],
    ':t7' => $tagValues[6],
]);

// セッション初期化 & 完了ページへ
unset($_SESSION['sketch'], $_SESSION['selected_tags']);
header("Location: partnership_sketch_complete.php");
exit;
?>
