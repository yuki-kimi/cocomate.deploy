<?php
session_start();
$sketch = $_SESSION['sketch'] ?? [];
$tags = $_SESSION['selected_tags'] ?? [];

if (empty($sketch)) {
    echo "スケッチ情報がありません。";
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>最終確認</title>
  <style>
    body { font-family: sans-serif; background: #fff7f7; padding: 40px; color: #333; }
    .container { max-width: 800px; margin: auto; background: #fff; padding: 32px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-top: 8px solid #f28c8c; }
    h1 { color: #f28c8c; text-align: center; }
    .block { margin-bottom: 30px; }
    .question { font-weight: bold; }
    .answer { background: #f8eaea; padding: 10px; border-radius: 6px; margin-top: 5px; white-space: pre-wrap; }
    .tag { background: #f28c8c; color: white; padding: 6px 10px; border-radius: 20px; margin: 2px; display: inline-block; }
    .button { display: block; margin: 30px auto 0; padding: 12px 30px; background: #f28c8c; color: white; border: none; border-radius: 6px; font-size: 16px; text-align: center; cursor: pointer; }
  </style>
</head>
<body>
  <div class="container">
    <h1>パートナーシップスケッチ 最終確認</h1>

    <?php foreach ($sketch as $i => $item): ?>
      <div class="block">
        <div class="question">Q<?= $i + 1 ?>. <?= htmlspecialchars($item['question']) ?></div>
        <div class="answer"><?= nl2br(htmlspecialchars($item['answer'])) ?></div>
      </div>
    <?php endforeach; ?>

    <h3>選択したタグ</h3>
    <div>
      <?php foreach ($tags as $tag): ?>
        <span class="tag"><?= htmlspecialchars($tag) ?></span>
      <?php endforeach; ?>
    </div>

    <form action="partnership_sketch_db.php" method="post">
      <button type="submit" class="button">この内容で保存する</button>
    </form>
  </div>
</body>
</html>
