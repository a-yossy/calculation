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
  <title>ユーザ一覧</title>
</head>
<body>
  <?php include '../layout/header.php' ?>
  <h2>ユーザ一覧</h2>
  <table>
    <tr>
      <th>名前</th>
      <th>倍率</th>
    </tr>
    <?php foreach($allUsers as $user): ?>
      <tr>
        <td><?php echo h($user['name']) ?></td>
        <td><?php echo h($user['magnification']) ?></td>
      </tr>
    <?php endforeach ?>
  </table>
</body>
</html>
