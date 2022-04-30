<?php

require_once('dbc.php');
require_once('user.php');

class PurchaseRecord extends Dbc {
  protected $tableName = 'purchase_record';

  public function purchaseRecordsCreate($purchaseRecordParams) {
    $sql = "INSERT INTO
              $this->tableName(user_id, amount_of_money, purchased_at)
            VALUES
              (:user_id, :amount_of_money, :purchased_at)";
    $dbh = $this->dbConnect();
    $dbh->beginTransaction();
    try {
      $stmt = $dbh->prepare($sql);
      foreach ($purchaseRecordParams['amount_of_money'] as $user_id => $amount_of_money) {
        $stmt->execute([
          ':user_id' => (int)$user_id,
          ':amount_of_money' => (int)$amount_of_money,
          ':purchased_at' => $purchaseRecordParams['purchased_at']
        ]);
      }
      $dbh->commit();
    } catch (PDOException $e) {
      $dbh->rollBack();
      exit($e->getMessage());
    }
  }

  public function updatePurchaseRecords($purchaseRecordIds) {
    $sql = "UPDATE $this->tableName SET
              is_completed = :is_completed
            WHERE
              id = :id";
    $dbh = $this->dbConnect();
    $dbh->beginTransaction();
    try {
      $stmt = $dbh->prepare($sql);
      foreach ($purchaseRecordIds as $purchaseRecordId) {
        $stmt->execute([
          ':id' => $purchaseRecordId,
          ':is_completed' => true
        ]);
      }
      $dbh->commit();
    } catch (PDOException $e) {
      $dbh->rollBack();
      exit($e->getMessage());
    }
  }

  public function getFormerlyPurchaseRecordsByUserIds($userIds) {
    $placeHolderOfUserIds = "";
    foreach ($userIds as $key => $userId) {
      $placeHolderOfUserIds .= ":user_id_$key,";
    }
    $placeHolderOfUserIds = rtrim($placeHolderOfUserIds, ",");
    $sql = "SELECT * FROM
              $this->tableName
            WHERE
              user_id
            IN
              ($placeHolderOfUserIds)
            ORDER BY
              purchased_at, user_id, id";
    $dbh = $this->dbConnect();
    $stmt = $dbh->prepare($sql);
    foreach ($userIds as $key => $userId) {
      $stmt->bindValue(":user_id_$key", (int)$userId, PDO::PARAM_INT);
    }
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
  }

  public function getNotCompletedFormerlyPurchaseRecordsByUserIds($userIds) {
    $placeHolderOfUserIds = "";
    foreach ($userIds as $key => $userId) {
      $placeHolderOfUserIds .= ":user_id_$key,";
    }
    $placeHolderOfUserIds = rtrim($placeHolderOfUserIds, ",");
    $sql = "SELECT * FROM
              $this->tableName
            WHERE
              is_completed = :is_completed
            AND
              user_id
            IN
              ($placeHolderOfUserIds)
            ORDER BY
              purchased_at, user_id, id";
    $dbh = $this->dbConnect();
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':is_completed', false, PDO::PARAM_BOOL);
    foreach ($userIds as $key => $userId) {
      $stmt->bindValue(":user_id_$key", (int)$userId, PDO::PARAM_INT);
    }
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
  }

  public function purchaseRecordValidate($purchaseRecordParams) {
    $errorMessages = [];
    if (empty($purchaseRecordParams['purchased_at'])) {
      $errorMessages[] = '購入日時を入力して下さい';
    }

    if ($purchaseRecordParams['purchased_at'] > date('Y-m-d')) {
      $errorMessages[] = '購入日時は今日以前から選択して下さい';
    }

    foreach ($purchaseRecordParams['amount_of_money'] as $user_id => $amount_of_money) {
      $user = new User();
      $userData = $user->getById($user_id);
      if ($amount_of_money !== '0' && empty($amount_of_money)) {
        $errorMessages[] = "{$userData['name']}の購入金額を入力して下さい";
      }

      if ($amount_of_money < 0) {
        $errorMessages[] = "{$userData['name']}の購入金額を0以上で入力して下さい";
      }
    }

    return $errorMessages;
  }
}
