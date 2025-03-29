<?php
session_start();
include('functions.php');
check_session_id();

// DB接続
$pdo = connect_to_db();

// ログインユーザーIDの取得
$current_user_id = $_SESSION['user_id'] ?? null;
if (!$current_user_id) {
    echo "Error: Not logged in.";
    exit();
}

// GETで渡されたuser_id（プロフィールを表示するユーザーID）
$user_id = $_GET['user_id'] ?? null;
if ($user_id) {
    // ユーザー情報とマッチング情報の表示
    $sql = '
        SELECT 
            profile_initial_table.user_id, 
            profile_initial_table.first_name, 
            profile_table.age, 
            profile_table.residence, 
            profile_table.comment, 
            profile_table.profile_photo
        FROM 
            profile_initial_table 
        JOIN 
            profile_table
        ON 
            profile_initial_table.user_id = profile_table.user_id
        WHERE 
            profile_initial_table.user_id = :user_id
    ';
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    try {
        $stmt->execute();
        $profile = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$profile) {
            echo "No profile found for user_id = $user_id.";
            exit();
        }
    } catch (PDOException $e) {
        echo json_encode(["sql error" => "{$e->getMessage()}"]);
        exit();
    }

    // 相互のマッチングを確認
    $sql = '
        SELECT 
            COUNT(*) AS is_matched
        FROM 
            like_table
        WHERE 
            (sender_id = :current_user_id AND receiver_id = :user_id) 
            AND EXISTS (
                SELECT 1 FROM like_table WHERE sender_id = :user_id AND receiver_id = :current_user_id
            )
    ';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':current_user_id', $current_user_id, PDO::PARAM_INT);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    try {
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $is_matched = $result['is_matched'] > 0;
    } catch (PDOException $e) {
        echo json_encode(["sql error" => "{$e->getMessage()}"]);
        exit();
    }

    // 都道府県リスト
    $prefectures = [
        0 => "未設定",
        1 => "北海道", 2 => "青森県", 3 => "岩手県", 4 => "宮城県", 5 => "秋田県",
        6 => "山形県", 7 => "福島県", 8 => "茨城県", 9 => "栃木県", 10 => "群馬県",
        11 => "埼玉県", 12 => "千葉県", 13 => "東京都", 14 => "神奈川県", 15 => "新潟県",
        16 => "富山県", 17 => "石川県", 18 => "福井県", 19 => "山梨県", 20 => "長野県",
        21 => "岐阜県", 22 => "静岡県", 23 => "愛知県", 24 => "三重県", 25 => "滋賀県",
        26 => "京都府", 27 => "大阪府", 28 => "兵庫県", 29 => "奈良県", 30 => "和歌山県",
        31 => "鳥取県", 32 => "島根県", 33 => "岡山県", 34 => "広島県", 35 => "山口県",
        36 => "徳島県", 37 => "香川県", 38 => "愛媛県", 39 => "高知県", 40 => "福岡県",
        41 => "佐賀県", 42 => "長崎県", 43 => "熊本県", 44 => "大分県", 45 => "宮崎県",
        46 => "鹿児島県", 47 => "沖縄県"
    ];

    // プロフィールカード生成
    if ($profile) {
        $img = "data:image/jpeg;base64," . base64_encode($profile['profile_photo']);
        $residence = $prefectures[$profile['residence']] ?? "未設定";

        // いいねが相互に行われている場合のみファミリーボタンを表示
        if ($is_matched) {
            $family_button = "<a href='future_sheet.php?user_id={$profile['user_id']}' class='view-family-btn'>家族観プロフィールを見る</a>";
        } else {
            $family_button = '';
        }

        $output = "
            <div class='card'>
                <img src='$img' alt='プロフィール写真' class='profile-photo'>
                <div class='basic-profile'>
                    <p>名前: {$profile['first_name']}</p>
                    <p>年齢: {$profile['age']}歳</p>
                    <p>居住地: $residence</p>
                </div>
                <div class='detail-profile'>
                    <p>{$profile['comment']}</p>
                </div>
                $family_button
            </div>
        ";
    } else {
        echo "プロフィールが見つかりませんでした。";
    }

} else {
    // ユーザーリストの表示
    echo "<h2>他のユーザーのコメントを見る</h2>";
    $users = [1, 2, 3]; // 他のユーザーのIDリスト（実際はDBから取得）
    foreach ($users as $other_user_id) {
        echo "<a href='candidate_profiles.php?user_id=$other_user_id'>ユーザー $other_user_id のコメントを見る</a><br>";
    }
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TomoMarry（トモマリ）</title>
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
        <div class="profile-list">
            <?= $output ?? '' ?>
        </div>
    </body>
    <style>
        body {
            margin-right: auto;
            margin-left: auto;
            padding: 0;
            width: 700px;
            font-size: 13px;
            color: rgba(0, 0, 0, 0.7);
            font-family: 'メイリオ', Meiryo, sans-serif;
            text-align: center;
        }
        header {
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
        .card {
            border: 1px solid #ccc;
            border-radius: 10px;
            margin: 20px 0;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #fff;
        }
        .profile-photo {
            width: 300px;
            height: 300px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
        }
        .basic-profile, .detail-profile {
            text-align: center;
        }
        .view-family-btn {
            margin-top: 15px;
            padding: 10px 20px;
            background-color: rgb(210, 117, 58);
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .view-family-btn:hover {
            background-color: rgb(210, 117, 58);
        }

        
    </style>
</html>

