<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>スケッチをシェアする前に</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <script>
    function goToNextSection() {
      const urlParams = new URLSearchParams(window.location.search);
      const user_id = urlParams.get('user_id');
      if (user_id) {
        window.location.href = 'future_sheet_comment01.php?user_id=' + user_id;
      }
    }
    function goToProfile() {
      window.location.href = 'profile_read.php';
    }
  </script>
  <style>
    body {
      font-family: 'Poppins',
      margin: 0;
      padding: 0;
      background-color: #f9f9f9;
      color: #333;
    }

    .container {
      max-width: 700px;
      margin: 0 auto;
      padding: 0 20px;
    }

    header {
    max-width: 700px;
      margin: 0 auto;
      text-align: center;
      background-color: #f28c8c;
      color: white;
      padding: 20px 0;
      position: relative;
    }

    header .container {
      position: relative;
      text-align: center;
    }

    header::after {
      content: "";
      display: block;
      height: 4px;
      background: linear-gradient(to right, #ffffff00, #fff, #ffffff00);
      margin-top: 10px;
    }

    h1 {
      margin: 0;
      font-size: 24px;
    }

    main {
      margin: 30px auto;
    }

    main section {
      margin-bottom: 40px;
    }

    h2 {
      color: #f28c8c;
    }

    .button-section {
      text-align: center;
      margin: 50px 0;
      display: flex;
      justify-content: center;
      gap: 40px;
    }

    .next-btn, .top-btn {
      padding: 12px 24px;
      font-size: 18px;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
      border: none;
    }

    .next-btn {
      background-color: #f28c8c;
      color: white;
    }

    .next-btn:hover {
      background-color: #e06c6c;
    }

    .top-btn {
      background-color: #888;
      color: white;
    }

    .top-btn:hover {
      background-color: #666;
    }

    footer {
      max-width: 700px;
      margin: 0 auto;
      text-align: center;
      background-color: #f28c8c;
      color: white;
      text-align: center;
      padding: 10px;
      margin-top: 50px;
    }
  </style>
</head>

<body>
  <header>
    <div class="container">
      <h1>スケッチをシェアする前に</h1>
    </div>
  </header>

  <main class="container">
    <section>
      <h2>未来の話しをするまえに</h2>
      <p>これから「2人の未来シート」をもとに、大切なパートナーとの未来について話し合うんですね。とても素敵な時間になると思います。でも、いざ話し始めると「え、そう思ってたの？」と驚くこともあるかもしれません。それは悪いことではなく、お互いをもっと深く知るチャンスです。今日は、人生の先輩として、円滑に話し合いを進めるためのアドバイスをお伝えしますね。</p>
    </section>

    <section>
      <h2>1. 正解を決めようとしないこと</h2>
      <p>まず、「絶対にこうすべき」という答えを出そうとしなくて大丈夫です。人の考えは時間とともに変わるもの。今この瞬間に100％一致しなくても、お互いの気持ちを知ることが大切です。大事なのは「どんな考え方をしているのか」を共有すること。</p>
    </section>

    <section>
      <h2>2. 「違い」ではなく「価値観の背景」に目を向ける</h2>
      <p>もし意見が違ったとしても、「なんでそう思うの？」と聞いてみてください。たとえば、「お金はきっちり管理したい派」と「ゆるく管理したい派」だったとしても、その背景には「安心して暮らしたい」「自由に生きたい」というそれぞれの価値観があるはず。違いを受け入れながら、お互いが納得できる落としどころを探せるといいですね。</p>
    </section>

    <section>
      <h2>3. 「妥協」ではなく「すり合わせ」</h2>
      <p>話し合いのゴールは「どちらかが我慢する」ことではありません。「どこまでなら受け入れられるか」「どうすればお互い気持ちよく折り合いがつくか」を一緒に考えることが大事です。譲れないことがあるなら、相手にも「あなたの大事なことも尊重したい」と伝えてくださいね。</p>
    </section>

    <section>
      <h2>4. 未来の「イメージ」を共有する</h2>
      <p>「どんな生活をしたいか？」を話すときは、できるだけ具体的にイメージしてみてください。たとえば、「休日はどう過ごしてる？」「疲れたとき、相手にどうしてほしい？」など。ふたりが大切にしたい時間をすり合わせることで、より現実的な未来像が見えてくるはずです。</p>
    </section>

    <section>
      <h2>5. 「これから一緒に考えていこう」と余白を残す</h2>
      <p>人生は長いもの。今話して決めたことも、数年後には状況が変わるかもしれません。「今はこう考えてるけど、また一緒に考えようね」と、未来の変化を前提にしておくと、話しやすくなるし、関係にも柔軟性が生まれます。</p>
    </section>

    <section class="button-section">
      <button onclick="goToProfile()" class="top-btn">トップへ戻る</button>
      <button onclick="goToNextSection()" class="next-btn">話し合いに進む</button>
    </section>
  </main>

  <footer>
    <p>&copy; 2025 CocoMate. All Rights Reserved.</p>
  </footer>
</body>
</html>
