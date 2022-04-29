<?php

require_once('dbc.php');

class PurchaseRecord extends Dbc {
  protected $tableName = 'purchase_record';

  public function purchaseRecordsCreate($purchaseRecordParams, $allUser) {
    $sql = "INSERT INTO
              $this->tableName(user_id, amount_of_money, purchased_at)
            VALUES
              (:user_id, :amount_of_money, :purchased_at)";
    $dbh = $this->dbConnect();
    $personalExpenditures = $this->getAmountOfMoneyOfEach($purchaseRecordParams, $allUser);
    $dbh->beginTransaction();
    try {
      $stmt = $dbh->prepare($sql);
      foreach ($personalExpenditures as $user_id => $amount_of_money) {
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
    $sql = "SELECT * FROM $this->tableName WHERE user_id IN ($placeHolderOfUserIds) ORDER BY purchased_at, user_id";
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
    $sql = "SELECT * FROM $this->tableName WHERE is_completed = :is_completed AND user_id IN ($placeHolderOfUserIds) ORDER BY purchased_at, user_id";
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

  public function purchaseRecordValidate($purchaseRecordParams, $allUser) {
    $errorMessages = [];
    if (empty($purchaseRecordParams['purchased_at'])) {
      $errorMessages[] = '購入日時を入力して下さい';
    }

    if ($purchaseRecordParams['purchased_at'] > date('Y-m-d')) {
      $errorMessages[] = '購入日時は今日以前から選択して下さい';
    }

    foreach ($allUser as $user) {
      if ($purchaseRecordParams["amount_of_money_{$user['id']}"] !== '0' && empty($purchaseRecordParams["amount_of_money_{$user['id']}"])) {
        $errorMessages[] = "{$user['name']}の購入金額を入力して下さい";
      }

      if ($purchaseRecordParams["amount_of_money_{$user['id']}"] < 0) {
        $errorMessages[] = "{$user['name']}の購入金額を0以上で入力して下さい";
      }
    }

    return $errorMessages;
  }

  private function getAmountOfMoneyOfEach($purchaseRecordParams, $allUser) {
    $personalExpenditures = [];
    foreach ($allUser as $user) {
      $personalExpenditures[$user['id']] = $purchaseRecordParams["amount_of_money_{$user['id']}"];
    }

    return $personalExpenditures;
  }
}
