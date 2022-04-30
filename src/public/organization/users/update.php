<?php
  require_once('../../../classes/purchase_record.php');
  require_once('../../../classes/user.php');
  require_once('../../../lib/security.php');
  require_once('../../../lib/user/function.php');

  $organizationId = $_GET['organization_id'];
  $purchaseRecord = new PurchaseRecord();
  $user = new User();
  $users = $user->getUsersByOrganizationId($organizationId);
  $userIds = array_map(function ($user) {
    return $user['id'];
  }, $users);
  $notCompletedFormerlyPurchaseRecords = $purchaseRecord->getNotCompletedFormerlyPurchaseRecordsByUserIds($userIds);
  $notCompletedFormerlyPurchaseRecordIds = array_map(function($purchaseRecord) {
    return $purchaseRecord['id'];
  }, $notCompletedFormerlyPurchaseRecords);
  $purchaseRecord->updatePurchaseRecords($notCompletedFormerlyPurchaseRecordIds);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>購入履歴更新</title>
</head>
<body>
  <?php include '../../layout/header.php' ?>
  <h2>購入履歴更新</h2>
  <?php include 'layout/url.php' ?>
  <div>
    <p>購入履歴を更新しました</p>
  </div>
</body>
</html>
