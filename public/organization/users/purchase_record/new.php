<?php
  require_once('../../../../classes/user.php');
  require_once('../../../../lib/security.php');

  $organizationId = $_GET['organization_id'];
  $user = new User();
  $users = $user->getUsersByOrganizationId($organizationId);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>購入履歴登録</title>
</head>
<body>
  <?php include '../../../layout/header.php' ?>
  <h2>購入履歴登録</h2>
  <?php include '../layout/url.php' ?>
  <form action="/public/organization/users/purchase_record/create.php" method="post">
    <input type="hidden" name="organization_id" value="<?php echo $organizationId ?>">
    <div>
      <p>購入日時</p>
      <input type="date" name="purchased_at" required max="<?php echo date('Y-m-d') ?>">
    </div>
    <?php foreach($users as $user): ?>
      <div>
        <h3><?php echo $user['name'] ?></h3>
      </div>
      <div>
        <p>購入金額</p>
        <input type="number" name="amount_of_money[<?php echo $user['id'] ?>]" min="0" required>
      </div>
    <?php endforeach ?>
    <div>
      <p><input type="submit" value="作成"></p>
    </div>
  </form>
</body>
</html>
