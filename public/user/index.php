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
  <title>TOPページ</title>
</head>
<body>
  <h1>計算アプリ</h1>
  <h2>TOPページ</h2>
  <p>
    <a href="/public/user">TOPページ</a>
    <a href="/public/user/new.php">ユーザ登録</a>
    <a href="/public/purchase_record/new.php">購入履歴登録</a>
    <a href="/public/purchase_record/">購入履歴一覧</a>
  </p>
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
