<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>質問フォーム</title>
    <style>
        body {
            display: flex;
            justify-content: center; /* 横方向の中央揃え */
            align-items: flex-start; /* 縦方向の位置を上に寄せる */
            height: 100vh;           /* ビューポートの高さに合わせる */
            font-family: 'メイリオ', Meiryo, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 20px;
        }

        /* 質問コンテナのスタイル */
        .question-container {
            display: none;
            background-color: rgb(247, 242, 240);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            width: 100%;  /* 幅を100%にして、画面に合わせる */
            max-width: 700px; /* 最大幅を700pxに制限 */
            box-sizing: border-box; /* パディングを含めた幅を計算 */
            margin-top: 30px; /* 少し上に寄せる */
        }

        .question-container.active {
            display: block;
        }

        /* ヘッダー */
        h2 {
            color: rgb(200, 100, 50);
        }

        /* ラベル */
        label {
            font-size: 1.1em;
            margin-left: 10px;
        }

        /* ラジオボタンの間隔を広げる */
        input[type="radio"] {
            margin: 15px 10px; /* 上下の間隔を広げる */
        }

        /* ボタン */
        button {
            background-color: rgb(200, 100, 50);
            color: white;
            border: none;
            padding: 10px 20px;
            margin-top: 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: rgb(180, 90, 40);
        }

        /* ナビゲーションボタン */
        .navigation-buttons {
            display: flex;
            justify-content: center; /* ボタンを中央揃え */
            gap: 20px; /* ボタン間のスペースを確保 */
            margin-top: 20px;
        }

        /* 「次へ」ボタン */
        .navigation-buttons button {
            background-color: rgb(200, 100, 50);
            color: rgb(245, 243, 242);
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .navigation-buttons button:hover {
            background-color: rgb(238, 200, 184);
        }

        /* 「戻る」ボタンをグレーに変更 */
        .navigation-buttons .back {
            background-color: rgb(169, 169, 169); /* グレー */
            color: rgb(245, 243, 242); /* グレーでも文字色を明るく */
        }

        .navigation-buttons .back:hover {
            background-color: rgb(150, 150, 150); /* ホバー時に少し暗く */
        }
    </style>
</head>
<body>

<form id="surveyForm" action="partnership_result.php" method="POST">
    <!-- 質問1 -->
    <div class="question-container active" id="question1">
        <h2>パートナーシップで最も重視するのは？</h2>
        <input type="radio" id="q1a" name="q1" value="a">
        <label for="q1a">心理的な支え合いや感情的なつながりを重視したい</label><br>

        <input type="radio" id="q1b" name="q1" value="b">
        <label for="q1b">生活の中でのサポートや実際的な助け合いが重要</label><br>

        <input type="radio" id="q1c" name="q1" value="c">
        <label for="q1c">自由で柔軟な関係で、お互いの時間を大切にしたい</label><br>

        <input type="radio" id="q1d" name="q1" value="d">
        <label for="q1d">家族のような深い絆を築き、親子のような関係を持ちたい</label><br>

        <div class="navigation-buttons">
            <button type="button" onclick="nextQuestion('question1', 'question2')">次へ</button>
        </div>
    </div>

    <!-- 質問2 -->
    <div class="question-container" id="question2">
        <h2>どのようなライフスタイルを望みますか？</h2>
        <input type="radio" id="q2a" name="q2" value="a">
        <label for="q2a">日々の生活を共に楽しみたい（家事や住む場所を一緒にシェアしたい）</label><br>

        <input type="radio" id="q2b" name="q2" value="b">
        <label for="q2b">自分の時間も大切にしつつ、時々会って楽しく過ごしたい</label><br>

        <input type="radio" id="q2c" name="q2" value="c">
        <label for="q2c">家庭や育児を一緒に支え合いながら過ごしたい</label><br>

        <input type="radio" id="q2d" name="q2" value="d">
        <label for="q2d">季節の行事や新しい挑戦、趣味を楽しみたい</label><br>

        <div class="navigation-buttons">
            <button type="button" class="back" onclick="nextQuestion('question2', 'question1')">戻る</button>
            <button type="button" onclick="nextQuestion('question2', 'question3')">次へ</button>
        </div>
    </div>

    <!-- 質問3 -->
    <div class="question-container" id="question3">
        <h2>理想的な関係における時間の過ごし方は？</h2>
        <input type="radio" id="q3a" name="q3" value="a">
        <label for="q3a">日常を共に過ごし、一緒に生活を楽しみたい</label><br>

        <input type="radio" id="q3b" name="q3" value="b">
        <label for="q3b">週末や特別な日だけ、ゆっくりと一緒に過ごしたい</label><br>

        <input type="radio" id="q3c" name="q3" value="c">
        <label for="q3c">自由な時間を尊重しながら、お互いのペースで過ごしたい</label><br>

        <input type="radio" id="q3d" name="q3" value="d">
        <label for="q3d">新しい冒険を共に体験し、わくわくする時間を過ごしたい</label><br>

        <div class="navigation-buttons">
            <button type="button" class="back" onclick="nextQuestion('question3', 'question2')">戻る</button>
            <button type="button" onclick="nextQuestion('question3', 'question4')">次へ</button>
        </div>
    </div>

    <!-- 質問4 -->
    <div class="question-container" id="question4">
        <h2>将来に対してのビジョンは？</h2>
        <input type="radio" id="q4a" name="q4" value="a">
        <label for="q4a">人生を楽しめるパートナーとして心の絆を大事にしたい</label><br>

        <input type="radio" id="q4b" name="q4" value="b">
        <label for="q4b">自由で柔軟に、自分のペースで過ごせるライフスタイルがいい</label><br>

        <input type="radio" id="q4c" name="q4" value="c">
        <label for="q4c">家族としてのつながりを大切にし、子どもや家庭を育んでいきたい</label><br>

        <input type="radio" id="q4d" name="q4" value="d">
        <label for="q4d">新しい挑戦や体験を共に楽しみ、成長したい</label><br>

        <div class="navigation-buttons">
            <button type="button" class="back" onclick="nextQuestion('question4', 'question3')">戻る</button>
            <button type="button" onclick="nextQuestion('question4', 'question5')">次へ</button>
        </div>
    </div>

    <!-- 質問5 -->
    <div class="question-container" id="question5">
        <h2>コミュニケーションのスタイルはどうしたいですか？</h2>
        <input type="radio" id="q5a" name="q5" value="a">
        <label for="q5a">落ち着いたペースでつながり、会ったときにじっくり向き合いたい</label><br>

        <input type="radio" id="q5b" name="q5" value="b">
        <label for="q5b">いつでも自由に連絡を取り合い、気が向いたときに気楽に話せる</label><br>

        <input type="radio" id="q5c" name="q5" value="c">
        <label for="q5c">毎日連絡を送り合い、日常の小さな出来事もシェアしたい</label><br>

        <input type="radio" id="q5d" name="q5" value="d">
        <label for="q5d">お互いのペースを大切にしつつ、必要なときにしっかり話せる</label><br>

        <div class="navigation-buttons">
            <button type="button" class="back" onclick="nextQuestion('question5', 'question4')">戻る</button>
            <button type="button" onclick="nextQuestion('question5', 'question6')">次へ</button>
        </div>
    </div>

    <!-- 質問6 -->
    <div class="question-container" id="question6">
        <h2>理想的な関係で求める自由度は？</h2>
        <input type="radio" id="q6a" name="q6" value="a">
        <label for="q6a">いつでも支え合い、深い絆でつながっていたい</label><br>

        <input type="radio" id="q6b" name="q6" value="b">
        <label for="q6b">時にはお互いに支え合いながら、個々の時間も大切にしたい</label><br>

        <input type="radio" id="q6c" name="q6" value="c">
        <label for="q6c">自由で柔軟な関係で、お互いのペースを尊重したい</label><br>

        <input type="radio" id="q6d" name="q6" value="d">
        <label for="q6d">生活の一部を共有しながら、お互いに頼れる存在でいたい
        </label><br>

        <div class="navigation-buttons">
            <button type="button" class="back" onclick="nextQuestion('question6', 'question5')">戻る</button>
            <button type="submit">結果を見る</button>
        </div>
    </div>
</form>

<script>
    // 次の質問に進むための関数
    function nextQuestion(currentQuestionId, nextQuestionId) {
        // 現在の質問を非表示にする
        document.getElementById(currentQuestionId).classList.remove('active');
        
        // 次の質問を表示する
        document.getElementById(nextQuestionId).classList.add('active');
    }

    // フォームが送信される前に選択された値をチェックして、結果に渡す
    document.getElementById('surveyForm').onsubmit = function(event) {
        // 質問1〜6の回答をフォームに追加
        let formData = new FormData(this);
        
        // 送信前にチェックする（必要に応じて）
        for (let [key, value] of formData.entries()) {
            console.log(key + ": " + value); // コンソールに確認用
        }
        
        // フォーム送信
        // event.preventDefault(); // 必要ならコメントアウト
        return true; // 送信を実行
    };
</script>

</body>
</html>
