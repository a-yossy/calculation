<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>ユーザ登録</title>
</head>
<body>
  <?php include '../layout/header.php' ?>
  <h2>ユーザ登録</h2>
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
