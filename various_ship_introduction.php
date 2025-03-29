<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=700">
  <title>パートナーシップ紹介カード</title>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&display=swap" rel="stylesheet">
  <style>

body {
  margin: 0;
  background-color: #fffde7;
  font-family: 'Noto Sans JP', sans-serif;
  display: flex;
  justify-content: center;
}

.title {
  text-align: center;
  font-size: 28px;
  font-weight: 700;
  color: #555;
  margin-bottom: 40px;
  letter-spacing: 1px;
}

    .container {
      width: 700px;
      padding: 40px 0 100px; /* 下にボタン分の余白を確保 */
    }

    .card-grid {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: space-between;
    }

    .card-img {
      width: calc(50% - 10px); /* 2枚並ぶように調整 */
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
    }

    .top-button {
      position: fixed;
      bottom: 20px;
      left: 50%;
      transform: translateX(-50%);
      width: 220px;
      padding: 12px 0;
      text-align: center;
      background-color:rgb(236, 156, 85);
      color: white;
      font-weight: bold;
      border-radius: 8px;
      text-decoration: none;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      transition: background-color 0.3s ease;
      z-index: 100;
    }

    .top-button:hover {
      background-color:rgb(246, 172, 138);
    }
  </style>
</head>
<body>
  <div class="container">
  <div class="title">いろんなパートナーシップ</div>
    <div class="card-grid">
      <img src="img/partnership_heart.png" alt="ハートパートナー" class="card-img">
      <img src="img/partnership_family.png" alt="ファミリーシップ" class="card-img">
      <img src="img/partnership_flex.png" alt="フレックスパートナー" class="card-img">
      <img src="img/partnership_weekend.png" alt="週末パートナー" class="card-img">
      <img src="img/partnership_life.png" alt="ライフパートナー" class="card-img">
      <img src="img/partnership_child.png" alt="子育てパートナー" class="card-img">
      <img src="img/partnership_journey.png" alt="ジャーニーメイト" class="card-img">
    </div>
  </div>

  <a href="index.php" class="top-button"> トップページへ戻る</a>
</body>
</html>

