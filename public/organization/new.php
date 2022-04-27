<?php
  require_once('../../classes/user.php');
  require_once('../../lib/security.php');

  $user = new User();
  $allUsers = $user->getAll();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>グループ作成</title>
</head>
<body>
  <?php include '../layout/header.php' ?>
  <h2>グループ作成</h2>
  <form action="/public/organization/create.php" method="post">
    <div>
      <p>グループ名</p>
      <input type="text" name="name" required>
    </div>
    <div>
      <p>ユーザ選択</p>
      <?php $userCount = 0 ?>
      <?php foreach ($allUsers as $user): ?>
        <div>
          <label><input type="checkbox" name="user_ids[]" value="<?php echo $user['id'] ?>"><?php echo h($user['name'].'-'.$user['magnification']) ?></label>
        </div>
        <?php $userCount++ ?>
      <?php endforeach ?>
    </div>
    <div>
      <p><input type="submit" value="作成"></p>
    </div>
  </form>
</body>
</html>
