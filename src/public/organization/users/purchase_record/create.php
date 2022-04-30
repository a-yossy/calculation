<?php
  require_once('../../../../classes/purchase_record.php');
  require_once('../../../../lib/security.php');

  $purchaseRecordParams = $_POST;
  $organizationId = $purchaseRecordParams['organization_id'];
  $purchaseRecord = new PurchaseRecord();
  $errorMessages = $purchaseRecord->purchaseRecordValidate($purchaseRecordParams);
  if (empty($errorMessages)) {
    $purchaseRecord->purchaseRecordsCreate($purchaseRecordParams);
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
