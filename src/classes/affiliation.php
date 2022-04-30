<?php

require_once('dbc.php');

class Affiliation extends Dbc {
  protected $tableName = 'affiliation';

  public function createAffiliation($organizationId, $userIds, $dbh) {
    $sql = "INSERT INTO
              $this->tableName(organization_id, user_id)
            VALUES
              (:organization_id, :user_id)";
    $stmt = $dbh->prepare($sql);
    foreach ($userIds as $userId) {
      $stmt->execute([
        ':organization_id' => (int)$organizationId,
        ':user_id' => (int)$userId
      ]);
    }
  }
}
