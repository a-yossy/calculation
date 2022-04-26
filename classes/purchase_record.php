<?php
  require_once('dbc.php');

  class PurchaseRecord extends Dbc {
    protected $tableName = 'purchase_record';

    public function purchaseRecordsCreate($purchaseRecordParams, $allUser) {
      $values = "";
      foreach ($allUser as $user) {
        $values .= "(:user_id_{$user['id']}, :amount_of_money_{$user['id']}, :purchased_at_{$user['id']}),";
      }
      $values = rtrim($values, ",");
      $sql = "INSERT INTO
                $this->tableName(user_id, amount_of_money, purchased_at)
              VALUES
                $values";
      $dbh = $this->dbConnect();
      $personalExpenditures = $this->calculateAmount($purchaseRecordParams, $allUser);
      $dbh->beginTransaction();
      try {
        $stmt = $dbh->prepare($sql);
        foreach ($personalExpenditures as $user_id => $amount_of_money) {
          $stmt->bindValue(":user_id_{$user_id}", $user_id, PDO::PARAM_INT);
          $stmt->bindValue(":amount_of_money_{$user_id}", $amount_of_money, PDO::PARAM_STR);
          $stmt->bindValue(":purchased_at_{$user_id}", $purchaseRecordParams['purchased_at'], PDO::PARAM_STR);
        }
        $stmt->execute();
        $dbh->commit();
      } catch (PDOException $e) {
        $dbh->rollBack();
        exit($e->getMessage());
      }
    }

    public function getFormerlyPurchaseRecords() {
      $sql = "SELECT * FROM $this->tableName ORDER BY purchased_at, user_id";
      $dbh = $this->dbConnect();
      $stmt = $dbh->query($sql);
      $result = $stmt->fetchAll();
      return $result;
    }

    public function getNotCompletedFormerlyPurchaseRecords() {
      $sql = "SELECT * FROM $this->tableName WHERE is_completed = :is_completed ORDER BY purchased_at, user_id";
      $dbh = $this->dbConnect();
      $stmt = $dbh->prepare($sql);
      $stmt->bindValue(':is_completed', false, PDO::PARAM_BOOL);
      $stmt->execute();
      $result = $stmt->fetchAll();
      return $result;
    }

    public function purchaseRecordValidate($purchaseRecordParams, $allUser) {
      $errorMessages = array();
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

    private function calculateAmount($purchaseRecordParams, $allUser) {
      $sumOfMoney = 0;
      foreach ($allUser as $user) {
        $sumOfMoney += $purchaseRecordParams["amount_of_money_{$user['id']}"];
      }

      $personalExpenditures = array();
      foreach ($allUser as $user) {
        $personalExpenditures[$user['id']] = $purchaseRecordParams["amount_of_money_{$user['id']}"] - $sumOfMoney * $user['magnification'];
      }

      return $personalExpenditures;
    }
  }
?>
