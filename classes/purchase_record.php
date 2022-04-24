<?php
  require_once('../classes/dbc.php');

  class PurchaseRecord extends Dbc {
    protected $tableName = 'purchase_record';

    public function purchaseRecordCreate($purchaseRecordParams) {
      $sql = "INSERT INTO
                $this->tableName(user_id, amount_of_money, purchased_at)
              VALUES
                (:user_id, :amount_of_money, :purchased_at)";
      $dbh = $this->dbConnect();
      $dbh->beginTransaction();
      try {
        $stmt = $dbh->prepare($sql);
      } catch (PDOException $e) {
        $dbh->rollBack();
        exit($e->getMessage());
      }
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
        if (empty($purchaseRecordParams["amount_of_money_{$user['id']}"])) {
          $errorMessages[] = "{$user['name']}の購入金額を入力して下さい";
        }

        if ($purchaseRecordParams["amount_of_money_{$user['id']}"] < 0) {
          $errorMessages[] = "{$user['name']}の購入金額を0以上で入力して下さい";
        }
      }

      return $errorMessages;
    }
  }
?>
