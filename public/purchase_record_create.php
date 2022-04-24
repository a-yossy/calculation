<?php
  require_once('../classes/purchase_record.php');
  require_once('../classes/user.php');

  $user = new User();
  $allUser = $user->getAll();
  $purchaseRecordParams = $_POST;
  $purchaseRecord = new PurchaseRecord();
  $errorMessages = $purchaseRecord->purchaseRecordValidate($purchaseRecordParams, $allUser);
  if (empty($errorMessages)) {
    $purchaseRecord->purchaseRecordCreate($purchaseRecordParams, $allUser);
  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>購入履歴作成</title>
</head>
<body>
  <h1>計算アプリ</h1>
  <h2>購入履歴作成</h2>
  <p><a href="/public">TOPページ</a></p>
  <div>
    <?php if (empty($errorMessages)): ?>
      <p>購入履歴を作成しました</p>
    <?php else: ?>
      <?php foreach($errorMessages as $errorMessage): ?>
        <p><?php echo $errorMessage ?></p>
      <?php endforeach ?>
    <?php endif ?>
  </div>
  <p><a href="/public/purchase_record_new.php">戻る</a></p>
</body>
</html>
