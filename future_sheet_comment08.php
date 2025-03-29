
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

        .advice-box {
            max-width: 700px;
            background: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            margin: 20px auto;
            display: flex;
            align-items: center;
            text-align: left;
        }

        .advice-text-container {
            flex: 1;
            margin-right: 20px;
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
            background: rgb(251, 237, 216);
            padding: 10px;
            border-radius: 5px;
        }

        .advice-image {
            width: 40%;
            height: auto;
            border-radius: 8px;
            object-fit: cover;
        }
    </style>
</head>
<body>

<h2 class="section-title">８．金銭面について（家計のやりくりについて・管理方法など）</h2>

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
$query = "SELECT family_comment_08 FROM profile_familyvalue_table WHERE user_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$user_id]);
$user_family_comment = $stmt->fetchColumn();

// 他のユーザーのIDを取得（URLパラメータが必須）
$other_user_id = $_GET['user_id'] ?? null;

if (!$other_user_id) {
    // 他のユーザーIDが指定されていない場合、エラーメッセージを表示
    echo "他のユーザーIDが指定されていません。";
    exit;
}

// 他のユーザーの情報を取得
$other_user_name = "不明なユーザー";
$other_user_family_comment = "コメントなし";

if ($other_user_id) {
    $query = "SELECT i.first_name, p.family_comment_08
              FROM profile_familyvalue_table p
              JOIN profile_initial_table i ON p.user_id = i.user_id
              WHERE p.user_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$other_user_id]);
    $other_user_data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($other_user_data) {
        $other_user_name = $other_user_data['first_name'] ?? '不明なユーザー';
        $other_user_family_comment = $other_user_data['family_comment_08'] ?? 'コメントなし';
    }
}
?>

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
        <p>お金の価値観はリアルだけど大切なテーマ。重くならないように、「どんなことには惜しまず使う？」など、ポジティブな面から話してみるといいです。</p>
        <p>生活のバランス感覚が見えてくるので、お互いの無理のない関係を築くためのヒントになります。</p>
        </div>
    </div>
    <img src="img/future_sheet_comment.png" alt="アドバイス画像" class="advice-image">
</div>

<div class="button-section">
    <!-- もどるボタンに相手のuser_idを使用 -->
    <button class="nav-button" onclick="window.location.href='future_sheet_comment07.php?user_id=<?php echo htmlspecialchars($other_user_id, ENT_QUOTES, 'UTF-8'); ?>'">前にもどる</button>    
    <!-- 次にすすむボタン -->
    <button class="nav-button" onclick="window.location.href='future_sheet_comment09.php?user_id=<?php echo htmlspecialchars($other_user_id, ENT_QUOTES, 'UTF-8'); ?>'">次にすすむ</button>
</div>
</body>
</html>