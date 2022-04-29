<?php
  require_once('../../../../classes/organization.php');
  require_once('../../../../classes/user.php');
  require_once('../../../../classes/purchase_record.php');
  require_once('../../../../lib/security.php');
  require_once('../../../../lib/purchase_record/function.php');

  $organizationId = $_GET['organization_id'];
  $organization = new Organization();
  $organization = $organization->getById($organizationId);
  $user = new User();
  $users = $user->getUsersByOrganizationId($organizationId);
  $userIds = array_map(function ($user) {
    return $user['id'];
  }, $users);
  $purchaseRecord = new PurchaseRecord();
  $formerlyPurchaseRecords = $purchaseRecord->getFormerlyPurchaseRecordsByUserIds($userIds);
  $totalAmountOfEachByDate = getTotalAmountOfEachByDate($formerlyPurchaseRecords);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>購入履歴一覧</title>
</head>
<body>
  <?php include '../../../layout/header.php' ?>
  <h2>購入履歴一覧</h2>
  <?php include '../layout/url.php' ?>
  <table border="1">
    <tr>
      <th>日付</th>
      <?php foreach ($users as $user): ?>
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
