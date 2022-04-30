<?php

require_once('dbc.php');
require_once('user.php');
require_once('affiliation.php');

class Organization extends Dbc {
  protected $tableName = 'organization';

  public function organizationCreate($organizationParams) {
    $sql = "INSERT INTO
              $this->tableName(name)
            VALUES
              (:name)";
    $dbh = $this->dbConnect();
    $dbh->beginTransaction();
    try {
      $stmt = $dbh->prepare($sql);
      $stmt->bindValue(':name', $organizationParams['name'], PDO::PARAM_STR);
      $stmt->execute();
      $organizationId = $dbh->lastInsertId();
      $affiliation = new Affiliation();
      $affiliation->createAffiliation($organizationId, $organizationParams['user_ids'], $dbh);
      $dbh->commit();
    } catch (PDOException $e) {
      $dbh->rollBack();
      exit($e->getMessage());
    }
  }

  public function organizationValidate($organizationParams) {
    $errorMessages = [];
    if (empty($organizationParams['name'])) {
      $errorMessages[] = 'グループ名を入力して下さい';
    }

    $alreadyExistingOrganizationNames = array_map(function ($organization) {
      return $organization['name'];
    }, $this->getAll());
    if (in_array($organizationParams['name'], $alreadyExistingOrganizationNames)) {
      $errorMessages[] = '既に存在するグループ名は入力出来ません';
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
}
