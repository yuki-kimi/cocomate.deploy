<?php
session_start();

$tags = $_SESSION['generated_tags'] ?? [];

if (empty($tags)) {
    echo "タグがまだ生成されていません。";
    exit;
}

$selectedTags = $_SESSION['selected_tags'] ?? [];
while (count($tags) < 7) {
  $tags[] = "";
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>タグを選択</title>
  <style>
    body { font-family: sans-serif; padding: 40px; background: #fff7f7; color: #333; }
    .container { max-width: 700px; margin: auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 0 10px rgba(0,0,0,0.05); border-top: 8px solid #f28c8c; }
    h2 { color: #f28c8c; }
    .tag-group label { display: inline-block; margin: 6px; }
    .button { margin-top: 20px; padding: 10px 20px; background: #f28c8c; color: white; border: none; border-radius: 6px; font-size: 16px; }
  </style>
</head>
<body>
  <div class="container">
    <h2>あなたの価値観を表すタグ（最大7つ）</h2>
    <form method="post" action="partnership_sketch_savetags.php">
      <?php foreach ($tags as $tag): ?>
        <label>
          <input type="checkbox" name="tags[]" value="<?= htmlspecialchars($tag) ?>"
            <?= in_array($tag, $selectedTags) ? 'checked' : '' ?>>
          <?= htmlspecialchars($tag) ?>
        </label>
      <?php endforeach; ?>
      <p style="color:#888;">※最大7個まで選べます</p>
      <button type="submit" class="button">確認画面へ</button>
    </form>
  </div>

  <script>
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(cb => {
      cb.addEventListener('change', () => {
        const checked = document.querySelectorAll('input[type="checkbox"]:checked');
        if (checked.length > 7) {
          cb.checked = false;
          alert('最大7個までしか選べません。');
        }
      });
    });
  </script>
</body>
</html>
