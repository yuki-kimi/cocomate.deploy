<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>新規登録画面</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #fdfdfd;
      margin: 0;
      padding: 0;
      color: #333;
    }

    .container {
      max-width: 700px;
      margin: 0 auto;
    }

    header {
      background-color: #f28c8c;
      color: white;
      text-align: center;
      padding: 20px;
      border-radius: 0 0 10px 10px;
    }

    form {
      background-color: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      margin-top: 40px;
    }

    fieldset {
      border: none;
    }

    legend {
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 20px;
      color: #f28c8c;
    }

    div {
      margin-bottom: 20px;
    }

    input[type="text"] {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    button {
      background-color: #f28c8c;
      color: white;
      padding: 12px 24px;
      font-size: 16px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    button:hover {
      background-color: #e06b6b;
    }

    .button-section {
      text-align: center;
      margin-top: 30px;
    }

    .back-button {
      margin-top: 20px;
      display: inline-block;
      text-align: center;
      background-color: #888;
      color: white;
      padding: 10px 20px;
      text-decoration: none;
      border-radius: 5px;
      transition: background-color 0.3s;
    }

    .back-button:hover {
      background-color: #666;
    }
  </style>
</head>

<body>

  <div class="container">
    <header>
      <h1>新規登録</h1>
    </header>

    <form action="profile_initial_create.php" method="POST">
      <fieldset>
        <legend>新規登録フォーム</legend>

        <div>
          姓: <input type="text" name="family_name" required>
        </div>

        <div>
          名：<input type="text" name="first_name" required>
        </div>

        <div>
          メールアドレス: <input type="text" name="email_address" required>
        </div>

        <div>
          パスワード: <input type="text" name="password" required>
        </div>

        <div class="button-section">
          <button type="submit">新規登録</button>
        </div>
      </fieldset>
    </form>

    <div class="button-section">
      <a href="index.php" class="back-button">トップへ戻る</a>
    </div>
  </div>

</body>
</html>
