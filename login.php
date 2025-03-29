

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ログイン画面</title>
</head>

<body>
  <form action="profile_login_act.php" method="POST">
    
    <fieldset>
      <div>
       メールアドレス<input type="text" name="email_address">
      </div>
      <div>
       パスワード <input type="text" name="password">
      </div>
      <div>
        <button>ログイン</button>
      </div>
      <div>
      <a href="profile_initial_input.php"><button type="button">新規登録</button></a>
      </div>
    </fieldset>
  </form>
</body>

<style>
    body {
      font-family: 'Arial', sans-serif;
      background-color: #f4f4f9;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      box-sizing: border-box;
    }

    fieldset {
      background-color: white;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
    }

    div {
      margin-bottom: 20px;
    }

    input[type="text"], input[type="password"] {
      width: 100%;
      padding: 12px;
      margin: 8px 0;
      border: 1px solid #ddd;
      border-radius: 4px;
      box-sizing: border-box;
      font-size: 1rem;
    }

    button {
      background-color:rgb(122, 119, 119);
      color: white;
      border: none;
      padding: 12px;
      width: 100%;
      border-radius: 4px;
      cursor: pointer;
      font-size: 1rem;
    }

    button:hover {
      background-color:rgb(202, 199, 198);
    }

    a {
      display: block;
      text-align: center;
      margin-top: 10px;
    }

    a button {
      background-color: #f28c8c;
      color: white;
      border: none;
      padding: 12px;
      width: 100%;
      border-radius: 4px;
      cursor: pointer;
      font-size: 1rem;
    }

    a button:hover {
      background-color:rgb(253, 232, 226);
    }

    /* スマホや小さい画面用のレスポンシブ対応 */
    @media (max-width: 480px) {
      body {
        padding: 10px;
      }

      fieldset {
        padding: 20px;
      }
    }
  </style>

</html>