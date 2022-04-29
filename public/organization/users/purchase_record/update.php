<?php
  require_once('../../../../classes/purchase_record.php');
  require_once('../../../../lib/security.php');

  $organizationId = $_GET['organization_id'];
  $purchaseRecordIds = $_GET['purchase_record_ids'];
  $purchaseRecordIds = explode(',', $purchaseRecordIds);
  $purchaseRecord = new PurchaseRecord();
  $purchaseRecord->updatePurchaseRecords($purchaseRecordIds);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>購入履歴更新</title>
</head>
<body>
  <?php include '../../../layout/header.php' ?>
  <h2>購入履歴更新</h2>
  <?php include '../layout/url.php' ?>
  <div>
    <p>購入履歴を更新しました</p>
  </div>
</body>
</html>
