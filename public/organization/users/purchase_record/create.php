<?php
  require_once('../../../../classes/purchase_record.php');
  require_once('../../../../classes/user.php');

  $purchaseRecordParams = $_POST;
  $organizationId = $purchaseRecordParams['organization_id'];
  $user = new User();
  $users = $user->getUsersByOrganizationId($organizationId);
  $purchaseRecord = new PurchaseRecord();
  $errorMessages = $purchaseRecord->purchaseRecordValidate($purchaseRecordParams, $users);
  if (empty($errorMessages)) {
    $purchaseRecord->purchaseRecordsCreate($purchaseRecordParams, $users);
  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>購入履歴作成</title>
</head>
<body>
  <?php include '../../../layout/header.php' ?>
  <h2>購入履歴作成</h2>
  <?php include '../layout/url.php' ?>
  <div>
    <?php if (empty($errorMessages)): ?>
      <p>購入履歴を作成しました</p>
    <?php else: ?>
      <?php foreach($errorMessages as $errorMessage): ?>
        <p><?php echo $errorMessage ?></p>
      <?php endforeach ?>
    <?php endif ?>
  </div>
</body>
</html>
