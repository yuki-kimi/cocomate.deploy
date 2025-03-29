<?php
session_start();
require_once('functions.php');

check_session_id(); // ログインチェック
$pdo = connect_to_db();

$userId = $_SESSION['user_id'] ?? null;

// 質問のラベル一覧（画面表示用）
$questions = [
    '1. 将来の展望（ライフプラン）',
    '2. なぜ結婚ではなくパートナーシップを選んだのか',
    '3. どのような生活をしていきたいのか',
    '4. 自身のこだわりやゆずれないこと',
    '5. 理想のパートナーシップ像について',
    '6. 家族や友人との付き合い方について',
    '7. 理想の距離感について',
    '8. 金銭面について',
    '9. 生活について（同居or別居、家事など）',
    '10. 子どもを授かりたいか',
];

// 直近の回答データを取得
$sql = "SELECT * FROM profile_familyvalue_table WHERE user_id = :user_id ORDER BY created_at DESC LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([':user_id' => $userId]);
$family = $stmt->fetch(PDO::FETCH_ASSOC);

// タグ一覧を取得
$sql = "SELECT tag FROM sketch_tags WHERE user_id = :user_id ORDER BY created_at DESC LIMIT 7";
$stmt = $pdo->prepare($sql);
$stmt->execute([':user_id' => $userId]);
$tags = $stmt->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>パートナーシップスケッチ一覧</title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #fff7f7;
      padding: 40px;
      color: #333;
    }
    .container {
      max-width: 800px;
      margin: auto;
      background: #fff;
      padding: 32px;
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
      border-top: 8px solid #f28c8c;
    }
    h2 {
      color: #f28c8c;
      margin-bottom: 24px;
    }
    .qa {
      margin-bottom: 20px;
    }
    .question {
      font-weight: bold;
      margin-bottom: 4px;
    }
    .tag-list {
      margin-top: 32px;
    }
    .tag {
      display: inline-block;
      background: #e0eaff;
      color: #333;
      padding: 6px 12px;
      border-radius: 20px;
      margin: 4px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>あなたのパートナーシップスケッチ</h2>

    <?php if ($family): ?>
      <?php for ($i = 1; $i <= 10; $i++): ?>
        <div class="qa">
          <div class="question"><?= htmlspecialchars($questions[$i - 1]) ?></div>
          <div class="answer"><?= nl2br(htmlspecialchars($family["family_comment_0$i"])) ?></div>
        </div>
      <?php endfor; ?>
    <?php else: ?>
      <p>まだ回答が登録されていません。</p>
    <?php endif; ?>

    <?php if ($tags): ?>
      <div class="tag-list">
        <h3>あなたを表すタグ</h3>
        <?php foreach ($tags as $tag): ?>
          <span class="tag"><?= htmlspecialchars($tag) ?></span>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>
