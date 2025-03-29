<?php
session_start();

// OpenAI APIキー
$apiKey = 
// 回答10個を取得
$sketch = $_SESSION['sketch'] ?? [];

if (count($sketch) !== 10) {
    echo "回答が不完全です。";
    exit;
}

// 回答を1つの文字列にまとめる
$allAnswers = '';
foreach ($sketch as $i => $item) {
    $allAnswers .= "Q" . ($i + 1) . ": " . $item['answer'] . "\n";
}

// ChatGPTへのプロンプト
$prompt = <<<EOT
以下は、ある人がユーザーが書いた理想のパートナーシップの関係の回答です。
この人の価値観や特徴をよく表す「タグ」を**30個**、簡潔な日本語の言葉や短いフレーズで**カンマ区切りのみで出力**してください。

注意点：
- タグ以外の文（「候補」や説明など）は出力しないでください。
- 30個未満になる場合は、マッチングアプリでよく使われる価値観キーワードを参考に補ってください（例：安心感, 趣味共有, 経済的自立 など）

タグ出力例：
自由重視, 信頼, 距離感大事, 金銭感覚合う, 安心感, 一緒に成長したい, ...

以下、ユーザーの回答です：

{$allAnswers}
EOT;

// OpenAI APIへリクエスト
$ch = curl_init(" ");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer {$apiKey}",
]);

$data = [
    'model' => 'gpt-4o-mini',
    'messages' => [
        ['role' => 'user', 'content' => $prompt]
    ],
    'max_tokens' => 300,
    'temperature' => 0.7,
];

curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);

// レスポンスからタグを取り出す
$rawTags = $result['choices'][0]['message']['content'] ?? '';
$tags = array_map('trim', explode(',', $rawTags));
$tags = array_filter($tags); // 空要素除去
$tags = array_slice($tags, 0, 30); // 最大30個に制限

// セッションに保存して選択画面へ
$_SESSION['generated_tags'] = $tags;
header('Location: partnership_sketch_selecttags.php');
exit;
