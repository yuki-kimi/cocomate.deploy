<?php
session_start();

// ログイン確認
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// ログインユーザーのID
$user_id = $_SESSION['user_id'];

// DB接続
include('functions.php');
$pdo = connect_to_db();

// あなたのコメントを取得
$query = "SELECT family_comment_02 FROM profile_familyvalue_table WHERE user_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$user_id]);
$user_family_comment = $stmt->fetchColumn();

// 他のユーザーのIDをGETパラメータで取得
$other_user_id = $_GET['user_id'] ?? null;

if (!$other_user_id) {
    // `other_user_id`がURLに指定されていない場合、エラーメッセージを表示
    echo "他のユーザーIDが指定されていません。";
    exit;
}

// 他のユーザーの名前（first_name）とコメントを取得
$query = "SELECT i.first_name, f.family_comment_02 FROM profile_initial_table i JOIN profile_familyvalue_table f ON i.user_id = f.user_id WHERE i.user_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$other_user_id]);
$other_user = $stmt->fetch(PDO::FETCH_ASSOC);

// 変数を設定
$other_user_name = $other_user['first_name'] ?? '名前不明';
$other_user_family_comment = $other_user['family_comment_02'] ?? 'コメントがありません';

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cocomate（ココメイト）</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
            text-align: center;
        }

        .section-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            padding: 15px;
            border-bottom: 3px solid rgb(210, 117, 58);
            background: #ffffff;
            border-radius: 8px;
            display: inline-block;
            margin-bottom: 20px;
        }

        .comment-box {
            max-width: 600px;
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            text-align: left;
        }

        .comment-title {
            font-size: 18px;
            font-weight: bold;
            color:rgb(210, 117, 58);
            margin-bottom: 5px;
        }

        .comment-text {
            font-size: 16px;
            color: #555;
            background: #f1f1f1;
            padding: 10px;
            border-radius: 5px;
        }

        /* ボタンのスタイル */
        .button-section {
            margin-top: 30px;
        }

        .nav-button {
            background-color: rgb(210, 117, 58);
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 18px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin: 0 10px;
        }

        .nav-button:hover {
            background-color: rgb(180, 90, 40);
        }

        /* アドバイスボックスのスタイル */
        .advice-box {
            max-width: 700px;
            background: #f9f9f9;
            padding: 20px;
            border-radius: 10px;

            margin: 20px auto;
            display: flex;
            align-items: center; /* テキストと画像を垂直方向に中央揃え */
            text-align: left;
        }

        .advice-text-container {
            flex: 1; /* テキスト部分が残りのスペースを占める */
            margin-right: 20px; /* 画像との間隔を設定 */
        }

        .advice-title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .advice-text {
            font-size: 16px;
            color: #555;
            background:rgb(251, 237, 216);;
            padding: 10px;
            border-radius: 5px;
        }

        /* 画像のスタイル */
        .advice-image {
            width:40%; /* 画像の幅 */
            height: auto;
            border-radius: 8px; /* 画像の角を丸く */
            object-fit: cover; /* 画像が切れないように設定 */
        }
    </style>
</head>
<body>

<h2 class="section-title">２．なぜ結婚ではなくパートナシップを選んだのか。</h2>

<div class="comment-box">
    <div class="comment-title">あなたのコメント</div>
    <div class="comment-text"><?php echo htmlspecialchars($user_family_comment, ENT_QUOTES, 'UTF-8'); ?></div>
</div>

<div class="comment-box">
    <div class="comment-title"><?php echo htmlspecialchars($other_user_name, ENT_QUOTES, 'UTF-8'); ?> さんのコメント</div>
    <div class="comment-text"><?php echo htmlspecialchars($other_user_family_comment, ENT_QUOTES, 'UTF-8'); ?></div>
</div>

<div class="advice-box">
    <div class="advice-text-container">
        <div class="advice-title">対話を深めるためのワンポイント</div>
        <div class="advice-text">
        <p>結婚という枠にとらわれない生き方をどう考えているかが表れる部分です。</p>
        <p>相手の選択に共感したり、自分との違いを優しく伝えたりすることで、お互いに安心して本音を話しやすくなります。否定せずに「そう思ったことある？」と投げかけてみて。</p>
        </div>
    </div>
    <img src="img/future_sheet_comment.png" alt="アドバイス画像" class="advice-image">
</div>

<!-- ナビゲーションボタン -->
<div class="button-section">
    <!-- もどるボタンに相手のuser_idを使用 -->
    <button class="nav-button" onclick="window.location.href='future_sheet_comment01.php?user_id=<?php echo htmlspecialchars($other_user_id, ENT_QUOTES, 'UTF-8'); ?>'">前にもどる</button>
    
    <!-- 次にすすむボタン -->
<!-- 次にすすむボタン -->
    <button class="nav-button" onclick="window.location.href='future_sheet_comment03.php?user_id=<?php echo htmlspecialchars($other_user_id, ENT_QUOTES, 'UTF-8'); ?>'">次にすすむ</button>
</div>

</body>
</html>
