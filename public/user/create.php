<?php
  require_once('../../classes/user.php');

  $userParams = $_POST;
  $user = new User();
  $errorMessages = $user->userValidate($userParams);
  if (empty($errorMessages)) {
    $user->userCreate($userParams);
  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>ユーザ作成</title>
</head>
<body>
  <h1>計算アプリ</h1>
  <h2>ユーザ作成</h2>
  <p>
    <a href="/public/user/index.php">TOPページ</a>
    <a href="/public/user/new.php">ユーザ登録</a>
    <a href="/public/purchase_record/new.php">購入履歴登録</a>
    <a href="/public/purchase_record/index.php">購入履歴一覧</a>
  </p>
  <div>
    <?php if (empty($errorMessages)): ?>
      <p>ユーザを作成しました</p>
    <?php else: ?>
      <?php foreach($errorMessages as $errorMessage): ?>
        <p><?php echo $errorMessage ?></p>
      <?php endforeach ?>
    <?php endif ?>
  </div>
</body>
</html>
