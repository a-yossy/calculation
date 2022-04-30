<?php
  require_once('/Applications/MAMP/htdocs/calculation/src/classes/organization.php');

  $organization = new Organization();
  $organization = $organization->getById($organizationId);
?>

<ul>
  <li><a href="/src/public/organization/users/show.php?organization_id=<?php echo $organization['id'] ?>"><?php echo h($organization['name']) ?>のユーザ一覧</a></li>
  <li><a href="/src/public/organization/users/purchase_record/new.php/?organization_id=<?php echo $organizationId ?>">購入履歴作成</a></li>
  <li><a href="/src/public/organization/users/purchase_record/?organization_id=<?php echo $organizationId ?>">購入履歴一覧</a></li>
</ul>
