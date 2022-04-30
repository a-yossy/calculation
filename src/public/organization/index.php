<?php
  require_once('../../classes/organization.php');
  require_once('../../lib/security.php');

  $organization = new Organization();
  $allOrganizations = $organization->getAll();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>TOPページ</title>
</head>
<body>
  <?php include '../layout/header.php' ?>
  <h2>TOPページ</h2>
  <ul>
    <?php foreach ($allOrganizations as $organization): ?>
      <li><a href="/src/public/organization/users/show.php?organization_id=<?php echo $organization['id'] ?>"><?php echo h($organization['name']) ?></a></li>
    <?php endforeach ?>
  </ul>
</body>
</html>
