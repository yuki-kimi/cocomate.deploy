<?php
session_start();

$sketch = $_SESSION['sketch'] ?? [];

if (empty($sketch)) {
    echo "まだパートナーシップスケッチが作成されていません。";
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>あなたのパートナーシップスケッチ</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
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
            background: #ffffff;
            padding: 32px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            border-top: 8px solid #f28c8c;
        }
        h1 {
            margin-bottom: 24px;
            font-size: 24px;
            text-align: center;
            color: #f28c8c;
        }
        .block {
            margin-bottom: 32px;
        }
        .question {
            font-weight: 600;
            font-size: 16px;
            margin-bottom: 8px;
            color: #444;
        }
        .answer {
            background: #f8eaea;
            padding: 12px;
            border-radius: 8px;
            font-size: 15px;
            white-space: pre-wrap;
            line-height: 1.6;
        }
        .tags {
            margin-top: 8px;
        }
        .tag {
            display: inline-block;
            background: #f28c8c;
            color: white;
            padding: 6px 14px;
            margin: 4px 4px 0 0;
            border-radius: 20px;
            font-size: 14px;
        }
        .btn-container {
            text-align: center;
            margin-top: 40px;
        }
        .tag-button {
            background: #f28c8c;
            color: white;
            padding: 12px 28px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.3s;
        }
        .tag-button:hover {
            background: #e07676;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>あなたのパートナーシップスケッチ</h1>

    <?php foreach ($sketch as $i => $item): ?>
        <div class="block">
            <div class="question">Q<?= $i + 1 ?>. <?= htmlspecialchars($item['question']) ?></div>
            <div class="answer"><?= nl2br(htmlspecialchars($item['answer'])) ?></div>

            <?php if (!empty($item['tags'])): ?>
                <div class="tags">
                    <?php foreach ($item['tags'] as $tag): ?>
                        <span class="tag"><?= htmlspecialchars($tag) ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
    <?php if (empty(array_filter(array_column($sketch, 'tags')))): ?>
    <p style="text-align:center; color:#999;">まだタグがついていません。</p>
    <?php endif; ?>

    <div class="btn-container">
    <a class="tag-button" href="generate_tags_with_openai.php">タグをつける</a>
    </div>
</div>

</body>
</html>
