<?php
  require_once('../classes/user.php');
  require_once('../lib/security.php');

  $user = new User();
  $allUser = $user->getAll();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>購入履歴登録</title>
</head>
<body>
  <h1>計算アプリ</h1>
  <h2>購入履歴登録</h2>
  <p>
    <a href="/public">TOPページ</a>
    <a href="/public/user_new.php">ユーザ登録</a>
    <a href="/public/purchase_record_new.php">購入履歴登録</a>
    <a href="/public/purchase_record_index.php">購入履歴一覧</a>
  </p>
  <form action="/public/purchase_record_create.php" method="post">
    <div>
      <p>購入日時</p>
      <input type="date" name="purchased_at" required max="<?php echo date('Y-m-d') ?>">
    </div>
    <?php foreach($allUser as $user): ?>
      <input type="hidden" name="user_id.<?php echo $user['id'] ?>" value="<?php echo $user['id'] ?>">
      <div>
        <h3><?php echo $user['name'] ?></h3>
      </div>
      <div>
        <p>購入金額</p>
        <input type="number" name="amount_of_money.<?php echo $user['id'] ?>" min="0" required>
      </div>
    <?php endforeach ?>
    <div>
      <p><input type="submit" value="作成"></p>
    </div>
  </form>
</body>
</html>
