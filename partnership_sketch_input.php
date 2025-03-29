<?php
session_start();

// ログインチェック
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$current = isset($_GET['q']) ? max(0, min((int)$_GET['q'], 9)) : 0;

// 質問リスト
$questions = [
  '将来の展望（ライフプラン）どんな人生を歩んでいきたいのか。',
  'なぜ結婚ではなくパートナーシップを選んだのか。',
  'どのような生活をしていきたいのか。',
  '自身のこだわりやゆずれないこと',
  '理想のパートナーシップ像について',
  '家族や友人との付き合い方について',
  '理想の距離感について',
  '金銭面について',
  '生活について',
  '子どもを授かりたいか。'
];

// セッションに未保存ならDBから回答を読み込む
if (!isset($_SESSION['sketch'])) {
    // DB接続
    include('functions.php'); // connect_to_db() が定義されている想定
    $pdo = connect_to_db();

    $stmt = $pdo->prepare("SELECT * FROM profile_familyvalue_table WHERE user_id = :user_id ORDER BY created_at DESC LIMIT 1");
    $stmt->execute([':user_id' => $user_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $_SESSION['sketch'] = [];
    for ($i = 1; $i <= 10; $i++) {
      $column = "family_comment_" . str_pad($i, 2, '0', STR_PAD_LEFT);
      $_SESSION['sketch'][] = [
          'question' => $questions[$i - 1],
          'answer' => $row[$column] ?? '',
          'tags' => []
      ];
  }
  
}

// 選択済みの回答（初期値）
$questionText = $_SESSION['sketch'][$current]['question'];
$previousAnswer = $_SESSION['sketch'][$current]['answer'] ?? '';
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>パートナーシップスケッチ Q<?= $current + 1 ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #fff7f7;
      padding: 40px;
      color: #333;
    }
    .container {
      max-width: 700px;
      margin: auto;
      background: #fff;
      padding: 32px;
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      border-top: 8px solid #f28c8c;
    }
    h2 {
      color: #f28c8c;
    }
    .progress {
      font-size: 14px;
      margin-bottom: 16px;
      color: #888;
      text-align: center;
    }
    textarea {
      width: 100%;
      height: 180px;
      font-size: 15px;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 8px;
      resize: vertical;
      font-family: 'Poppins', sans-serif;
    }
    .buttons {
      margin-top: 24px;
      display: flex;
      justify-content: space-between;
    }
    .btn {
      padding: 10px 20px;
      background: #f28c8c;
      border: none;
      border-radius: 6px;
      color: white;
      font-size: 15px;
      cursor: pointer;
    }
    .btn:hover {
      background: #e07676;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="progress">Q<?= $current + 1 ?>/10</div>
  <h2><?= htmlspecialchars($questionText) ?></h2>

  <form action="partnership_sketch_question_save.php" method="post">
    <input type="hidden" name="question_index" value="<?= $current ?>">
    <textarea name="user_answer" placeholder="あなたの考えを自由に記入してください"><?= htmlspecialchars($previousAnswer) ?></textarea>

    <div class="buttons">
      <?php if ($current > 0): ?>
        <a class="btn" href="?q=<?= $current - 1 ?>">← 前へ</a>
      <?php else: ?>
        <div></div>
      <?php endif; ?>
      <button type="submit" class="btn"><?= $current === 9 ? 'すべて完了' : '次へ →' ?></button>
    </div>
  </form>
</div>

</body>
</html>
