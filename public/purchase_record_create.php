<?php
  require_once('../classes/purchase_record.php');
  require_once('../classes/user.php');

  $user = new User();
  $allUser = $user->getAll();
  $purchaseRecordParams = $_POST;
  $purchaseRecord = new PurchaseRecord();
  $errorMessages = $purchaseRecord->purchaseRecordValidate($purchaseRecordParams, $allUser);
  var_dump($errorMessages);
?>
