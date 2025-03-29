<?php

session_start();
include('functions.php');
check_session_id();

// DB接続
$pdo = connect_to_db();

// ログイン中のユーザーIDを取得
$user_id = $_SESSION['user_id'];

// SQL作成&実行
$sql = 'SELECT * FROM profile_familyvalue_table WHERE user_id = :user_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$output = "";
foreach ($result as $record) {
  $output .= "
      <div class='question-box'>
        <div class='question'>１．将来の展望（ライフプラン）どんな人生を歩んでいきたいのか。</div>
        <div class='answer'>{$record["family_comment_01"]}</div>
      </div>
      <div class='question-box'>
        <div class='question'>２．なぜ結婚ではなくパートナシップを選んだのか。</div>
        <div class='answer'>{$record["family_comment_02"]}</div>
      </div>
      <div class='question-box'>
        <div class='question'>３．どのような生活をしていきたいのか。</div>
        <div class='answer'>{$record["family_comment_03"]}</div>
      </div>
      <div class='question-box'>
        <div class='question'>４．自身のこだわりやゆずれないこと</div>
        <div class='answer'>{$record["family_comment_04"]}</div>
      </div>
      <div class='question-box'>
        <div class='question'>５．理想のパートナーシップ像について</div>
        <div class='answer'>{$record["family_comment_05"]}</div>
      </div>
      <div class='question-box'>
        <div class='question'>６．家族や友人との付き合い方について</div>
        <div class='answer'>{$record["family_comment_06"]}</div>
      </div>
      <div class='question-box'>
        <div class='question'>７．理想の距離感について</div>
        <div class='answer'>{$record["family_comment_07"]}</div>
      </div>
      <div class='question-box'>
        <div class='question'>８．金銭面について</div>
        <div class='answer'>{$record["family_comment_08"]}</div>
      </div>
      <div class='question-box'>
        <div class='question'>９．生活について</div>
        <div class='answer'>{$record["family_comment_09"]}</div>
      </div>
      <div class='question-box'>
        <div class='question'>１０．子どもを授かりたいか。</div>
        <div class='answer'>{$record["family_comment_10"]}</div>
      </div>
  ";
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>パートナーシップスケッチ</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    body {
  margin: 0;
  padding: 0;
  font-family: 'Poppins',
  background-color: #fff8f4;
  color: #333;
}

main {
  max-width: 760px;
  margin: 40px auto;
  padding: 20px;
}

fieldset {
  border: none;
  padding: 0;
}

legend {
  font-size: 24px;
  font-weight: bold;
  text-align: center;
  margin-bottom: 30px;
  color: #e88c8c;
}

header {
    background-color: #fff;
    border-bottom: 1px solid #ddd;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    padding: 12px 0;
    position: sticky;
    top: 0;
    z-index: 100;
}

nav ul {
    display: flex;
    justify-content: space-around;
    align-items: center;
    list-style-type: none;
    margin: 0 auto;
    padding: 0;
    max-width: 700px;
}

nav ul li {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    width: 60px;
    text-align: center;
}

nav ul li a,
nav ul li img {
    text-decoration: none;
    color: #333;
}

nav ul li img {
    width: 36px;
    height: 36px;
    object-fit: contain;
    margin-bottom: 4px;
    transition: transform 0.2s ease;
}

nav ul li img:hover {
    transform: scale(1.1);
}

.edit-button-container {
  text-align: right;
  max-width: 760px;
  margin: 20px auto 0;
  padding: 0 10px;
}

.edit-button {
  display: inline-block;
  background-color: #e88c8c;
  color: white;
  padding: 10px 20px;
  text-decoration: none;
  border-radius: 25px;
  font-size: 16px;
  transition: background-color 0.3s ease;
}

.edit-button:hover {
  background-color: #d37070;
}

.my_familyvalue_area {
  max-width: 760px;
  margin: 0 auto;
}

.question-box {
  background-color: #fff;
  border-left: 6px solid #f5b5a5;
  padding: 20px;
  margin-bottom: 24px;
  border-radius: 10px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}

.question {
  font-weight: bold;
  font-size: 18px;
  color: #d86f6f;
  margin-bottom: 10px;
  text-align: left;
}

.answer {
  font-size: 15px;
  line-height: 1.6;
  text-align: left;
  color: #444;
  white-space: pre-wrap;
}


  </style>
</head>

<header>
<nav>
  <ul>
    <li>
      <a href="profile_read.php">
        <img src="img/サーチアイコン.png" alt="さがす"/>
      </a>
    </li>
    <li>
      <a href="#"><img src="img/いいねアイコン.png" alt="いいね"/></a>
    </li>
    <li>
      <a href="#"><img src="img/コメントアイコン7.png" alt="コメント"/></a>
    </li>
    <li>
      <a href="mypage.php"><img src="img/履歴書アイコン6.png" alt="マイページ"/></a>
    </li>
  </ul>
</nav>
</header>

<body>
  <form action="familyvalue_create.php" method="POST" enctype="multipart/form-data">
    <div class="edit-button-container">
      <a href="profile_familyvalue_input.php" class="edit-button">スケッチ編集</a>
    </div>
    <fieldset>
      <legend>パートナーシップスケッチ</legend>
      <div class="my_familyvalue_area">
        <?= $output ?>
      </div>
    </fieldset>
  </form>
</body>
</html>
