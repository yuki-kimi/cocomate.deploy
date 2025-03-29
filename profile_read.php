<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

$user_id = $_SESSION['user_id'] ?? null;
if ($user_id === null) {
    echo "Error: User not logged in.";
    exit();
}

include('functions.php');
check_session_id();
$pdo = connect_to_db();

// すでにいいねしたユーザーID一覧
$sql = 'SELECT receiver_id FROM like_table WHERE sender_id = :user_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$liked_users = $stmt->fetchAll(PDO::FETCH_COLUMN);

// 自分以外のプロフィールを取得
$sql = 'SELECT * FROM profile_table WHERE user_id != :user_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$profiles = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 都道府県マップ
$prefectures = [
  0 => "未設定", 1 => "北海道", 2 => "青森県", 3 => "岩手県", 4 => "宮城県",
  5 => "秋田県", 6 => "山形県", 7 => "福島県", 8 => "茨城県", 9 => "栃木県",
  10 => "群馬県", 11 => "埼玉県", 12 => "千葉県", 13 => "東京都", 14 => "神奈川県",
  15 => "新潟県", 16 => "富山県", 17 => "石川県", 18 => "福井県", 19 => "山梨県",
  20 => "長野県", 21 => "岐阜県", 22 => "静岡県", 23 => "愛知県", 24 => "三重県",
  25 => "滋賀県", 26 => "京都府", 27 => "大阪府", 28 => "兵庫県", 29 => "奈良県",
  30 => "和歌山県", 31 => "鳥取県", 32 => "島根県", 33 => "岡山県", 34 => "広島県",
  35 => "山口県", 36 => "徳島県", 37 => "香川県", 38 => "愛媛県", 39 => "高知県",
  40 => "福岡県", 41 => "佐賀県", 42 => "長崎県", 43 => "熊本県", 44 => "大分県",
  45 => "宮崎県", 46 => "鹿児島県", 47 => "沖縄県"
];

$output = "";
foreach ($profiles as $record) {
    $img = "data:image/jpeg;base64," . base64_encode($record["profile_photo"]);
    $is_liked = in_array($record["user_id"], $liked_users);
    $like_class = $is_liked ? "liked" : "not-liked";
    $like_text = $is_liked ? "いいね済み" : "いいね";

    $output .= '
    <div class="card">
        <a href="future_candidate_profiles.php?user_id=' . $record["user_id"] . '" class="card-link">
            <img src="' . $img . '" alt="" class="profile_img">
            <div>' . $record["age"] . '歳</div>
            <div>' . $prefectures[$record["residence"]] . '</div>
            <div class="comment">' . $record["comment"] . '</div>
        </a>
        <a href="#" class="like-button ' . $like_class . '" data-receiver-id="' . $record["user_id"] . '">' . $like_text . '</a>
    </div>';
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>プロフィール一覧</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    body {
      max-width: 700px;
      margin: auto;
      font-family: 'Poppins', sans-serif;
      font-size: 13px;
      text-align: center;
    }
    header {
      background-color: #fff;
      border-bottom: 1px solid #ccc;
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
    .profile_card_area {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
      margin-top: 20px;
    }
    .card {
      border: 1px solid #ccc;
      border-radius: 12px;
      padding: 16px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      text-align: center;
    }
    .profile_img {
      width: 160px;
      height: 160px;
      border-radius: 50%;
      object-fit: cover;
    }
    .like-button {
      display: inline-block;
      margin-top: 8px;
      padding: 8px 16px;
      border-radius: 20px;
      text-decoration: none;
      font-size: 14px;
      border: 1px solid #aaa;
      transition: background-color 0.2s;
    }
    .liked {
      background-color: #f28c8c;
      color: white;
    }
    .not-liked {
      background-color: white;
      color: #f28c8c;
      border: 1px solid #f28c8c;
    }

    a.card-link {
  text-decoration: none;
  color: inherit; /* 必要なら文字色も継承 */
}
  </style>
</head>

<body>
  <!-- ナビゲーション -->
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

  <!-- jQuery（必要ならここ） -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- プロフィールカード表示 -->
  <div class="profile_card_area">
    <?= $output ?>
  </div>

  <!-- JavaScript：いいね切り替え処理 -->
  <script>
  document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.like-button').forEach(button => {
      button.addEventListener('click', function (e) {
        e.preventDefault();
        const receiverId = this.dataset.receiverId;
        console.log("Clicked receiver_id:", receiverId);
        fetch('like_create.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: `receiver_id=${receiverId}`
        })
        .then(res => res.json())
        .then(data => {
          console.log("Response:", data);
          if (data.status === 'liked') {
            this.classList.remove('not-liked');
            this.classList.add('liked');
            this.textContent = 'いいね済み';
          } else if (data.status === 'unliked') {
            this.classList.remove('liked');
            this.classList.add('not-liked');
            this.textContent = 'いいね';
          }
        })
        .catch(err => console.error("Fetch error:", err));
      });
    });
  });
  </script>
</body>
</html>

<?php

