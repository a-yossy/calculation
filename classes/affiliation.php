<?php

require_once('dbc.php');

class Affiliation extends Dbc {
  protected $tableName = 'affiliation';

  public function createAffiliation($organizationId, $userIds, $dbh) {
    $values = "";
    foreach ($userIds as $userId) {
      $values .= "(:organization_id_$userId, :user_id_$userId),";
    }
    $values = rtrim($values, ",");
    $sql = "INSERT INTO
              $this->tableName(organization_id, user_id)
            VALUES
              $values";
    $stmt = $dbh->prepare($sql);
    foreach ($userIds as $userId) {
      $stmt->bindValue(":organization_id_$userId", (int)$organizationId, PDO::PARAM_INT);
      $stmt->bindValue(":user_id_$userId", (int)$userId, PDO::PARAM_INT);
    }
    $stmt->execute();
  }
}
