<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>ユーザ登録</title>
</head>
<body>
  <h1>計算アプリ</h1>
  <h2>ユーザ登録</h2>
  <p>
    <a href="/public/user">TOPページ</a>
    <a href="/public/user/new.php">ユーザ登録</a>
    <a href="/public/purchase_record/new.php">購入履歴登録</a>
    <a href="/public/purchase_record/index.php">購入履歴一覧</a>
  </p>
  <form action="/public/user/create.php" method="post">
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
