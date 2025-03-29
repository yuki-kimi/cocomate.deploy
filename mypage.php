<?php
session_start();

$user_id = $_SESSION['user_id'] ?? null;

if ($user_id === null) {
    echo "Error: User not logged in.";
    exit();
}

include("functions.php");
check_session_id();
$pdo = connect_to_db();

// プロフィール取得
$sql = 'SELECT * FROM profile_table WHERE user_id = :user_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$profiles = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 価値観タグ取得
$sql_tags = 'SELECT tag_01, tag_02, tag_03, tag_04, tag_05, tag_06, tag_07 
             FROM sketch_tags 
             WHERE user_id = :user_id 
             ORDER BY created_at DESC 
             LIMIT 1';
$stmt_tags = $pdo->prepare($sql_tags);
$stmt_tags->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt_tags->execute();
$tag_row = $stmt_tags->fetch(PDO::FETCH_ASSOC);

// タグHTMLの初期化
$tag_list = [];
$tag_html = '';

if ($tag_row) {
    foreach ($tag_row as $tag) {
        if (!empty($tag)) {
            $tag_list[] = htmlspecialchars($tag, ENT_QUOTES);
        }
    }

    if (!empty($tag_list)) {
        $tag_html .= "<div class='tag-section'>";
        $tag_html .= "<p style='color:#f28c8c; font-weight: bold;'>あなたの価値観タグ</p>";
        foreach ($tag_list as $tag) {
            $tag_html .= "<span class='tag'>{$tag}</span>";
        }
        $tag_html .= "</div>";
    }
}

$output = "";

foreach ($profiles as $record) {
    $img = "data:image/jpeg;base64," . base64_encode($record["profile_photo"]);
    $comment = htmlspecialchars($record["comment"] ?? '', ENT_QUOTES);

    // desired_partnership タグ処理
    $desired_tags_html = "";
    if (!empty($record['desired_partnership'])) {
        $partnership_tags = explode(",", $record['desired_partnership']);
        $desired_tags_html .= "<div class='tag-section'>";
        $desired_tags_html .= "<p style='color:#6cbde8; font-weight: bold;'>望む関係性</p>";
        foreach ($partnership_tags as $tag) {
            $desired_tags_html .= "<span class='tag-partnership'>" . htmlspecialchars(trim($tag), ENT_QUOTES) . "</span>";
        }
        $desired_tags_html .= "</div>";
    }

    $output .= "
        <div class='profile-wrapper'>
            <div class='profile-photo'>
                <img src='$img' alt='プロフィール画像' class='profile_img'>
            </div>
            <p class='comment'>「{$comment}」</p>
            {$desired_tags_html}
            {$tag_html}
        </div>
    ";
}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>マイページ</title>
</head>

<header>
    <nav>
      <ul>
        <li><a href="profile_read.php"><img src="img/サーチアイコン.png" alt="さがす"/></a></li>
        <li><img src="img/いいねアイコン.png" alt="いいね"/></li>
        <li><img src="img/コメントアイコン7.png" alt="コメント"/></li>
        <li><a href="mypage.php"><img src="img/履歴書アイコン6.png" alt="プロフィール入力"></a></li>
      </ul>
    </nav>
</header>

<body>
    <legend><?= $_SESSION['first_name']?>さんのマイページ</legend>
    <!-- <a href="profile_input.php" class="button_edit">プロフィール編集ページ</a> -->
<main>
<section class="profile-photo-section">
  <?= $output ?>
  <div class="buttons">
    <a href="profile_input.php" class="btn">プロフィール</a>
    <a href="partnership_sketch_input.php" class="btn">パートナーシップスケッチ</a>
  </div>
</section>
  <a href="profile_logout.php" class="button_logout">ログアウト</a>
 </main>
</body>

<style>


body{
    margin-right: auto;
    margin-left: auto;
    padding:0;
    width: 700px;
    font-size: 13px;
    color: rgba(0,0, 0, 0.7);
    font-family: 'メイリオ', Meiryo, sans-serif;
    text-align:center;
}
header{
    background-color: #fff;
    border-bottom: 1px solid #ccc;
    text-align: center;
}

nav ul {
    display: flex;
    justify-content: space-evenly;
    align-items: center;
    padding: 5px;
    list-style-type: none;
    margin: 0;
}
nav ul li {
    display: inline-block;
}
nav ul li img {
    width: 40px;
    height: auto;
    object-fit: contain;
}

.comment {
    max-width: 350px;
    margin-top: 10px;
    font-size: 14px;
    color: #555;
    text-align: center;
    margin-left: auto;
    margin-right: auto;
}

 /* ボタンのデザイン */
a.button_edit {
      display: inline-block;
      padding: 12px 25px;
      margin: 10px;
      background-color: #f28c8c;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      font-size: 1.2em;
      text-align: center;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }

a.button_logout {
      display: inline-block;
      padding: 12px 25px;
      margin: 10px;
      background-color:rgb(122, 119, 119);
      color: white;
      text-decoration: none;
      border-radius: 5px;
      font-size: 1.2em;
      text-align: center;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }

a.button_edit:hover {
      background-color: #f28c8c;
    }

a.button_logout:hover {
      background-color:rgb(230, 223, 223);
    }


main {
    max-width: 700px;
    margin: 0 auto;
}

legend{
  padding-top: 20px;
}

section {
    margin-bottom: 30px;
    padding: 20px;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

section h2 {
    margin-bottom: 15px;
    font-size: 1.2rem;
    color: #f28c8c;
}

/* プロフィール写真 */
.profile-photo {
    width: 150px; /* 円の幅 */
    height: 150px; /* 円の高さ */
    margin: 0 auto; /* 中央揃え */
    border-radius: 50%; /* 円形にする */
    overflow: hidden; /* 円形以外を隠す */
    border: 1px solid rgb(169, 161, 155); /* 外枠 */
    display: flex; /* 子要素を中央揃えにするための設定 */
    justify-content: center; /* 水平方向の中央揃え */
    align-items: center; /* 垂直方向の中央揃え */
    background-color:rgb(244, 242, 230); /* 背景色（任意） */
}

.profile-photo img {
    width: 100%;
    height: 100%;  /* 高さも親要素に合わせる */
    object-fit: cover;
    display: block;
}

/* ボタン */
.btn {
    display: inline-block;
    padding: 10px 20px;
    margin: 5px;
    font-size: 1rem;
    color: white;
    text-decoration: none;
    background-color:  #f28c8c;
    border: 1px solid  #f28c8c;
    border-radius: 25px;
    transition: background-color 0.3s ease, opacity 0.3s ease;
    cursor: pointer;
}

.btn:hover {
    background-color:rgb(233, 194, 194);
}

.btn:disabled {
    background-color: #ccc;
    border-color: #aaa;
    cursor: not-allowed;
}

/* 足あとボタンといいね履歴ボタンの特別スタイル */
.footprint-section .btn,
.like-history-section .btn {
    width: 50%;
    margin: 10px auto;
    display: block;
}

.tag-list {
    margin-top: 10px;
}

.tag-section {
    background-color:rgb(254, 252, 252);
    padding: 16px;
    border-radius: 10px;
    margin-top: 20px;
    margin-bottom: 20px;
}


.tag {
    display: inline-block;
    background-color: white;
    color: #f28c8c;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 13px;
    border: 1px solid #f28c8c;
    margin: 4px;
}

/* パートナーシップタグ（水色） */
.tag-partnership {
    display: inline-block;
    background-color: white;
    color: #6cbde8;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 13px;
    border: 1px solid #6cbde8;
    margin: 4px;
}


</style>

</html>