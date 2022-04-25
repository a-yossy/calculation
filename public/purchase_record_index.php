<?php
  require_once('../classes/purchase_record.php');
  require_once('../classes/user.php');
  require_once('../lib/security.php');

  $user = new User();
  $allUsers = $user->getAll();
  $purchaseRecord = new PurchaseRecord();
  $formerlyPurchaseRecords = array();
  foreach ($purchaseRecord->getFormerlyPurchaseRecords() as $purchaseRecord) {
    $formerlyPurchaseRecords[$purchaseRecord['purchased_at']][$user->getById($purchaseRecord['user_id'])['name']]
      = $purchaseRecord['amount_of_money'];
  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>購入履歴一覧</title>
</head>
<body>
  <h1>計算アプリ</h1>
  <h2>購入履歴一覧</h2>
  <p>
    <a href="/public">TOPページ</a>
    <a href="/public/user_new.php">ユーザ登録</a>
    <a href="/public/purchase_record_new.php">購入履歴登録</a>
    <a href="/public/purchase_record_index.php">購入履歴一覧</a>
    <table border="1">
      <tr>
        <th>日付</th>
        <?php foreach ($allUsers as $user): ?>
          <th><?php echo h($user['name']) ?></th>
        <?php endforeach ?>
      </tr>
      <?php foreach ($formerlyPurchaseRecords as $purchasedAt => $purchaseRecord): ?>
        <tr>
          <td><?php echo h($purchasedAt) ?></td>
          <?php foreach ($purchaseRecord as $name => $amountOfMoney): ?>
            <td><?php echo h($amountOfMoney) ?></td>
          <?php endforeach ?>
        </tr>
      <?php endforeach ?>
    </table>
  </p>
</body>
</html>
