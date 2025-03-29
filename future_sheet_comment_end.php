<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

include('functions.php');
$pdo = connect_to_db();

$query = "SELECT family_comment_01, family_comment_02, family_comment_03, family_comment_04, family_comment_05, family_comment_06, family_comment_07, family_comment_08, family_comment_09, family_comment_10 
          FROM profile_familyvalue_table 
          WHERE user_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$user_id]);
$user_comments = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user_comments) {
    echo "あなたのコメントが見つかりませんでした。";
    exit;
}

$other_user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 2;

$query = "SELECT family_comment_01, family_comment_02, family_comment_03, family_comment_04, family_comment_05, family_comment_06, family_comment_07, family_comment_08, family_comment_09, family_comment_10 
          FROM profile_familyvalue_table 
          WHERE user_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$other_user_id]);
$other_user_data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$other_user_data) {
    echo "他のユーザーのコメントが見つかりませんでした。";
    exit;
}

$query_name = "SELECT first_name FROM profile_initial_table WHERE user_id = ?";
$stmt_name = $pdo->prepare($query_name);
$stmt_name->execute([$other_user_id]);
$other_user_name_data = $stmt_name->fetch(PDO::FETCH_ASSOC);

if (!$other_user_name_data) {
    echo "他のユーザーの名前が見つかりませんでした。";
    exit;
}

$other_user_name = $other_user_name_data['first_name'];

$questions = [
    "1. 将来の展望（ライフプラン）どんな人生を歩んでいきたいのか。",
    "2. なぜ結婚ではなくパートナシップを選んだのか。",
    "3. どのような生活をしていきたいのか。",
    "4. 自身のこだわりやゆずれないこと",
    "5. 理想のパートナーシップ像について",
    "6. 家族・友人との付き合い方について(周囲への紹介の仕方、家族旅行/冠婚葬祭など)",
    "7. 理想のパートナーシップ像について",
    "8. 金銭面について（家計のやりくりについて・管理方法など）",
    "9. 生活について（同居or別居、食事、家事、休暇、習慣など）",
    "10. 子どもを授かりたいか。（妊活を希望するかなど）"
];
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>こころスケッチシェア</title>
  <style>
    body {
      font-family: 'Helvetica Neue', sans-serif;
      background-color: #fef7f7;
      margin: 0;
      padding: 40px 20px;
      color: #444;
    }

    .container {
      max-width: 700px;
      margin: 0 auto;
    }

    h1 {
      text-align: center;
      font-size: 32px;
      color: #f28c8c;
      margin-bottom: 10px;
    }

    p.advice {
      text-align: center;
      color: #766f6f;
      font-size: 15px;
      margin-top: -5px;
      margin-bottom: 40px;
    }

    .question-section {
      margin-bottom: 50px;
    }

    .question-title {
      font-weight: 600;
      font-size: 18px;
      color: #333;
      margin-bottom: 20px;
      text-align: center;
    }

    .comment-group {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
    }

    .comment-box {
      position: relative;
      max-width: 48%;
      padding: 15px 20px;
      border-radius: 16px;
      font-size: 14px;
      line-height: 1.6;
      word-wrap: break-word;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
    }

    .comment-title {
      font-weight: bold;
      margin-bottom: 8px;
    }

    .comment-text {
      white-space: pre-wrap;
    }

    .comment-group {
  display: flex;
  flex-direction: column;
  gap: 20px;
  align-items: center;
}

.comment-box {
  position: relative;
  width: 90%;
  padding: 15px 20px;
  border-radius: 16px;
  font-size: 14px;
  line-height: 1.6;
  word-wrap: break-word;
  box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
}

.comment-box.you {
  background-color:rgb(252, 250, 250);
}

.comment-box.you::after {
  content: "";
  position: absolute;
  top: 15px;
  left: 15px;
  width: 0;
  height: 0;
  border-top: 10px solid transparent;
  border-bottom: 10px solid transparent;
  border-right: 10px :rgb(220, 208, 208);
}

.comment-box.other {
  background-color: #fcecec;
}

.comment-box.other::after {
  content: "";
  position: absolute;
  top: 15px;
  right: 15px;
  width: 0;
  height: 0;
  border-top: 10px solid transparent;
  border-bottom: 10px solid transparent;
  border-left: 10px solid #fcecec;
}


    @media (max-width: 768px) {
      .comment-group {
        flex-direction: column;
        align-items: center;
      }

      .comment-box {
        max-width: 90%;
      }

      .comment-box.you::after {
        left: 15px;
        border-right: 10px solid #ffe8e8;
      }

      .comment-box.other::after {
        right: 15px;
        border-left: 10px solid #fcecec;
      }
    }

    .button-section {
      text-align: center;
      margin-top: 40px;
    }

    .nav-button {
      background-color: #f28c8c;
      color: white;
      border: none;
      padding: 12px 24px;
      margin: 10px;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
      transition: background-color 0.3s ease;
    }

    .nav-button:hover {
      background-color: #d66e6e;
    }
  </style>
</head>
<body>

<div class="container">
  <h1>こころスケッチシェア</h1>
  <p class="advice">
    おつかれさまでした。対話を終えて改めて見つめなおす時間です。<br>
    自分と相手、それぞれのこころのスケッチを見比べながら、新しい気づきを感じてみてください。
  </p>

  <?php for ($i = 0; $i < 10; $i++): 
    $user_comment = isset($user_comments["family_comment_" . sprintf("%02d", $i + 1)]) ? htmlspecialchars($user_comments["family_comment_" . sprintf("%02d", $i + 1)], ENT_QUOTES, 'UTF-8') : "コメントがありません。";
    $other_user_comment = isset($other_user_data["family_comment_" . sprintf("%02d", $i + 1)]) ? htmlspecialchars($other_user_data["family_comment_" . sprintf("%02d", $i + 1)], ENT_QUOTES, 'UTF-8') : "コメントがありません。";
  ?>
    <div class="question-section">
      <div class="question-title"><?php echo $questions[$i]; ?></div>
      <div class="comment-group">
        <div class="comment-box you">
          <div class="comment-title">あなたのコメント</div>
          <div class="comment-text"><?php echo $user_comment; ?></div>
        </div>
        <div class="comment-box other">
          <div class="comment-title"><?php echo htmlspecialchars($other_user_name, ENT_QUOTES, 'UTF-8'); ?>さんのコメント</div>
          <div class="comment-text"><?php echo $other_user_comment; ?></div>
        </div>
      </div>
    </div>
  <?php endfor; ?>

  <div class="button-section">
    <button class="nav-button" onclick="window.location.href='future_sheet.php?user_id=<?php echo htmlspecialchars($other_user_id, ENT_QUOTES, 'UTF-8'); ?>'">前にもどる</button>
  </div>
</div>

</body>
</html>
