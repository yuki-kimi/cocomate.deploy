<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// タグ候補一覧
function get_default_matching_tags() {
    return [
        '価値観重視', '穏やかに過ごしたい', '趣味共有', 'ひとり時間大事', '笑いのツボが合う',
        '感情表現が豊か', '経済的自立', '家事分担したい', '週末ゆっくり派', '旅行好き',
        '読書好き', '食の好みが合う', 'ペット好き', '自然が好き', '映画好き',
        '運動が好き', '健康志向', '話し合いを大切に', '尊重し合いたい', '成長し合える関係',
        '家庭的', '柔軟な関係性', '恋愛に縛られない', '心の支えが欲しい', '安心して話せる',
        '穏やかな関係性', '将来を考えられる', '干渉しすぎない', '助け合いたい', '対等な関係'
    ];
}

function generate_tags_from_all_answers($sketch) {
    $allText = implode(' ', array_column($sketch, 'answer'));
    $tags = [];

    if (mb_stripos($allText, '自由') !== false) $tags[] = '自由重視';
    if (mb_stripos($allText, '家族') !== false) $tags[] = '家族思い';
    if (mb_stripos($allText, '距離') !== false) $tags[] = '心地よい距離感';
    if (mb_stripos($allText, 'お金') !== false || mb_stripos($allText, '金銭') !== false) $tags[] = '金銭感覚大事';
    if (mb_stripos($allText, '子ども') !== false) $tags[] = '子どもについて考えている';
    if (mb_stripos($allText, '信頼') !== false) $tags[] = '信頼を大切に';
    if (mb_stripos($allText, '共感') !== false) $tags[] = '共感重視';
    if (mb_stripos($allText, '仕事') !== false) $tags[] = 'キャリア重視';
    if (mb_stripos($allText, '一緒に') !== false) $tags[] = '共同生活希望';
    if (mb_stripos($allText, '安心') !== false) $tags[] = '安心感を求める';

    $defaultTags = get_default_matching_tags();
    foreach ($defaultTags as $tag) {
        if (count($tags) >= 30) break;
        if (!in_array($tag, $tags)) $tags[] = $tag;
    }

    return array_slice($tags, 0, 30);
}

// 回答取得
$sketch = $_SESSION['sketch'] ?? [];
if (empty($sketch)) {
    header("Location: partnership_sketch_result.php");
    exit;
}

// タグ生成＆保存
// $generatedTags = generate_tags_from_all_answers($sketch);
// $_SESSION['generated_tags'] = $generatedTags;
$_SESSION['selected_tags'] = $_SESSION['selected_tags'] ?? [];

// 次画面へ
header("Location: partnership_sketch_selecttags.php");
exit;
?>
