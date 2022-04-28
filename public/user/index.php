<?php
  require_once('../../classes/user.php');
  require_once('../../lib/security.php');
  require_once('../../classes/purchase_record.php');
  require_once('../../lib/user/function.php');

  $user = new User();
  $allUsers = $user->getAll();
  $purchaseRecord = new PurchaseRecord();
  $notCompletedFormerlyPurchaseRecords = $purchaseRecord->getNotCompletedFormerlyPurchaseRecords();
  $totalAmountOfEach = getTotalAmountOfEach($notCompletedFormerlyPurchaseRecords);
  $allUsersWithAmountOfMoney = getAllUsersWithAmountOfMoney($totalAmountOfEach, $allUsers);
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
      <th>合計金額</th>
    </tr>
    <?php foreach($allUsersWithAmountOfMoney as $name => $user): ?>
      <tr>
        <td><?php echo h($name) ?></td>
        <td><?php echo h($user['magnification']) ?></td>
        <td><?php echo h($user['amount_of_money']) ?></td>
      </tr>
    <?php endforeach ?>
  </table>
</body>
</html>
