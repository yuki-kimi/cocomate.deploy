<?php
session_start();

// 質問の定義
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

// セッションの初期化
if (!isset($_SESSION['sketch'])) {
    $_SESSION['sketch'] = [];
}

// フォームからのデータ取得
$index = (int)($_POST['question_index'] ?? 0);
$answer = mb_substr(trim($_POST['user_answer'] ?? ''), 0, 400); // 長さ制限（1000文字）

// 入力保存（範囲チェック付き）
if ($index >= 0 && $index < count($questions)) {
    $_SESSION['sketch'][$index] = [
        'question' => $questions[$index],
        'answer' => $answer,
        'tags' => [] // タグは後で
    ];
}

// 遷移処理
if ($index < 9) {
    header("Location: partnership_sketch_input.php?q=" . ($index + 1));
} else {
    header("Location: partnership_sketch_result.php");
}
exit;
