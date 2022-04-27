<?php
  require_once('../../classes/purchase_record.php');
  require_once('../../classes/user.php');
  require_once('../../lib/security.php');
  require_once('../../lib/purchase_record/function.php');

  $user = new User();
  $allUsers = $user->getAll();
  $purchaseRecord = new PurchaseRecord();
  $formerlyPurchaseRecords = $purchaseRecord->getFormerlyPurchaseRecords();
  $totalAmountOfEachByDate = getTotalAmountOfEachByDate($formerlyPurchaseRecords);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>購入履歴一覧</title>
</head>
<body>
  <?php include '../layout/header.php' ?>
  <h2>購入履歴一覧</h2>
  <table border="1">
    <tr>
      <th>日付</th>
      <?php foreach ($allUsers as $user): ?>
        <th><?php echo h($user['name']) ?></th>
      <?php endforeach ?>
    </tr>
    <?php foreach ($totalAmountOfEachByDate as $purchasedAt => $purchaseRecord): ?>
      <tr>
        <td><?php echo h($purchasedAt) ?></td>
        <?php foreach ($purchaseRecord as $name => $amountOfMoney): ?>
          <td><?php echo h($amountOfMoney) ?></td>
        <?php endforeach ?>
      </tr>
    <?php endforeach ?>
  </table>
</body>
</html>
