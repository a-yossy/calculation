<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>ユーザ登録</title>
</head>
<body>
  <h1>計算アプリ</h1>
  <h2>ユーザ登録</h2>
  <p><a href="/public">TOPページ</a></p>
  <form action="/public/user_create.php" method="post">
    <div>
      <p>名前</p>
      <input type="text" name="name" required>
    </div>
    <div>
      <p>倍率</p>
      <input type="number" name="magnification" min="0" max="1" step="0.01" required>
    </div>
    <div>
      <p><input type="submit" value="作成"></p>
    </div>
  </form>
</body>
</html>
