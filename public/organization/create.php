<?php
  require_once('../../classes/organization.php');

  $organizationParams = $_POST;
  $organization = new Organization();
  $errorMessages = $organization->organizationValidate($organizationParams);
  if (empty($errorMessages)) {
    $organization->organizationCreate($organizationParams);
  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>グループ作成</title>
</head>
<body>
  <?php include '../layout/header.php' ?>
  <h2>グループ作成</h2>
  <div>
    <?php if (empty($errorMessages)): ?>
      <p>グループを作成しました</p>
    <?php else: ?>
      <?php foreach($errorMessages as $errorMessage): ?>
        <p><?php echo $errorMessage ?></p>
      <?php endforeach ?>
    <?php endif ?>
  </div>
</body>
</html>
