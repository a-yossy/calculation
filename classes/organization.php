<?php

require_once('dbc.php');
require_once('user.php');

class Organization extends Dbc {
  protected $tableName = 'organization';

  public function organizationCreate($organizationParams) {
    $sql = "INSERT INTO
              $this->tableName(name)
            VALUES
              (:name)";
    $dbhOrganization = $this->dbConnect();
    $dbhAffilation = $this->dbConnect();
    $dbhOrganization->beginTransaction();
    $dbhAffilation->beginTransaction();
    try {
      $stmt = $dbhOrganization->prepare($sql);
      $stmt->bindValue(':name', $organizationParams['name'], PDO::PARAM_STR);
      $stmt->execute();
      $organizationId = $dbhOrganization->lastInsertId();
      $dbhOrganization->commit();
      $this->createAffilation($organizationId, $organizationParams['user_ids'], $dbhAffilation);
      $dbhAffilation->commit();
    } catch (PDOException $e) {
      $dbhOrganization->rollBack();
      $dbhAffilation->rollBack();
      exit($e->getMessage());
    }
  }

  public function organizationValidate($organizationParams) {
    $errorMessages = [];
    if (empty($organizationParams['name'])) {
      $errorMessages[] = 'グループ名を入力して下さい';
    }

    if (!array_key_exists('user_ids', $organizationParams)) {
      $errorMessages[] = 'ユーザを選択して下さい';
    } else {
      $magnification = 0;
      foreach ($organizationParams['user_ids'] as $user_id) {
        $user = new User();
        $magnification += $user->getById($user_id)['magnification'];
      }

      if ($magnification != 1) {
        $errorMessages[] = '倍率の合計が1になるようユーザを選択して下さい';
      }
    }

    return $errorMessages;
  }

  private function createAffilation($organizationId, $userIds, $dbhAffilation) {
    $values = "";
    foreach ($userIds as $userId) {
      $values .= "(:organization_id_$userId, :user_id_$userId),";
    }
    $values = rtrim($values, ",");
    $sql = "INSERT INTO
              affiliation(organization_id, user_id)
            VALUES
              $values";
    $stmt = $dbhAffilation->prepare($sql);
    foreach ($userIds as $userId) {
      $stmt->bindValue(":organization_id_$userId", (int)$organizationId, PDO::PARAM_INT);
      $stmt->bindValue(":user_id_$userId", (int)$userId, PDO::PARAM_INT);
    }
    $stmt->execute();
  }
}
