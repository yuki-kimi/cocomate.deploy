<?php
// セッション開始
session_start();
include('functions.php');
check_session_id();

$pdo = connect_to_db();
$user_id = $_SESSION['user_id'] ?? null;
if ($user_id === null) {
    exit('ユーザーIDが不正です');
}

// 登録済プロフィールの取得（フォームに再表示するため）
$sql = 'SELECT * FROM profile_table WHERE user_id = :user_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$existing_profile = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>プロフィール入力</title>
  <style>
    body {
      font-family: 'メイリオ', sans-serif;
      color: #333;
      max-width: 700px;
      margin: 0 auto;
    }
    form {
      max-width: 500px;
      margin: 0 auto;
      background: white;
      padding: 24px;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      border: 2px solid #f28c8c;
    }
    label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
      color: #f28c8c;
    }
    input[type="text"],
    input[type="date"],
    select,
    textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #f4baba;
      border-radius: 6px;
      margin-bottom: 16px;
      box-sizing: border-box;
      background-color: #fff0f0;
    }
    textarea {
      height: 80px; /* 一言コメント用に高さ調整 */
      resize: vertical; /* ユーザーが拡大可能に */
    }
    input[type="submit"] {
      background-color: #f28c8c;
      color: white;
      border: none;
      padding: 12px 20px;
      font-size: 16px;
      border-radius: 8px;
      cursor: pointer;
    }
    input[type="submit"]:hover {
      background-color: #e37373;
    }
  header {
  background-color: #fff;
  border-bottom: 1px solid #ccc;
  text-align: center;
  margin-bottom: 40px;
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

    
  </style>
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
  <form action="profile_create.php" method="POST" enctype="multipart/form-data">
    <label>生年月日</label>
    <input type="date" name="birthdate" value="<?= htmlspecialchars($existing_profile['birthdate'] ?? '', ENT_QUOTES) ?>" required>

    <label>居住地</label>
    <select name="residence" required>
      <?php
        $prefectures = ["未選択", "北海道", "青森県", "岩手県", "宮城県", "秋田県", "山形県", "福島県", "茨城県", "栃木県", "群馬県", "埼玉県", "千葉県", "東京都", "神奈川県", "新潟県", "富山県", "石川県", "福井県", "山梨県", "長野県", "岐阜県", "静岡県", "愛知県", "三重県", "滋賀県", "京都府", "大阪府", "兵庫県", "奈良県", "和歌山県", "鳥取県", "島根県", "岡山県", "広島県", "山口県", "徳島県", "香川県", "愛媛県", "高知県", "福岡県", "佐賀県", "長崎県", "熊本県", "大分県", "宮崎県", "鹿児島県", "沖縄県"];
        foreach ($prefectures as $i => $name) {
          $selected = (isset($existing_profile['residence']) && $existing_profile['residence'] == $i) ? 'selected' : '';
          echo "<option value='$i' $selected>$name</option>";
        }
      ?>
    </select>

    <label>一言コメント</label>
    <textarea name="comment" required><?= htmlspecialchars($existing_profile['comment'] ?? '', ENT_QUOTES) ?></textarea>

<label>望むパートナーシップの関係性（複数選択可）</label>
<div>
<?php
$types = [
  'ハートパートナー',
  'ファミリーシップ',
  'フレックスパートナー',
  '週末パートナー',
  'ライフパートナー',
  '子育てパートナー',
  'ジャーニーメイト',
];

// 既に登録されているデータ（カンマ区切りで保存されていると仮定）
$selected_types = isset($existing_profile['desired_partnership']) ? explode(',', $existing_profile['desired_partnership']) : [];

foreach ($types as $label) {
  $checked = in_array($label, $selected_types) ? 'checked' : '';
  echo "<label style='display:block; margin-bottom:10px;'>
          <input type='checkbox' name='desired_partnership[]' value='{$label}' {$checked}>
          {$label}
        </label>";
}
?>
</div>

</div>

    <label>プロフィール写真</label>
    <input type="file" name="profile_photo" accept="image/*">

    <input type="submit" value="保存">
  </form>
</body>
</html>
