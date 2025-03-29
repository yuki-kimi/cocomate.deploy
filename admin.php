<?php

session_start();
include("functions.php");
check_session_id();
check_is_admin();

// var_dump($_SESSION["is_admin"]);

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>管理者画面</title>
</head>

<body>
<h1>管理者ページ</h1>
</body>

</html>