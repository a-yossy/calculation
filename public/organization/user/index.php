<?php
  require_once('../../../classes/user.php');
  require_once('../../../classes/organization.php');
  require_once('../../../classes/purchase_record.php');
  require_once('../../../lib/user/function.php');
  require_once('../../../lib/security.php');

  $organizationId = $_GET['organization_id'];
  $organization = new Organization();
  $organization = $organization->getById($organizationId);
  $user = new User();
  $users = $user->getUsersByIds($organizationId);
  $userIds = array_map(function ($user) {
    return $user['id'];
  }, $users);
  $purchaseRecord = new PurchaseRecord();
  $notCompletedFormerlyPurchaseRecords = $purchaseRecord->getNotCompletedFormerlyPurchaseRecordsByUserIds($userIds);
  $totalAmountOfEach = getTotalAmountOfEach($notCompletedFormerlyPurchaseRecords);
  $usersWithAmountOfMoney = getAllUsersWithAmountOfMoney($totalAmountOfEach, $users);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php echo h($organization['name']) ?>のユーザ一覧</title>
</head>
<body>
  <?php include '../../layout/header.php' ?>
  <h2><?php echo h($organization['name']) ?>のユーザ一覧</h2>
  <table>
    <tr>
      <th>名前</th>
      <th>倍率</th>
      <th>合計金額</th>
    </tr>
    <?php foreach($usersWithAmountOfMoney as $name => $user): ?>
      <tr>
        <td><?php echo h($name) ?></td>
        <td><?php echo h($user['magnification']) ?></td>
        <td><?php echo h($user['amount_of_money']) ?></td>
      </tr>
    <?php endforeach ?>
  </table>
</body>
</html>
