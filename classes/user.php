<?php

require_once('dbc.php');

class User extends Dbc {
  protected $tableName = 'user';

  public function userCreate($userParams) {
    $sql = "INSERT INTO
              $this->tableName(name, magnification)
            VALUES
              (:name, :magnification)";
    $dbh = $this->dbConnect();
    $dbh->beginTransaction();
    try {
      $stmt = $dbh->prepare($sql);
      $stmt->bindValue(':name', $userParams['name'], PDO::PARAM_STR);
      $stmt->bindValue(':magnification', $userParams['magnification'], PDO::PARAM_STR);
      $stmt->execute();
      $dbh->commit();
    } catch (PDOException $e) {
      $dbh->rollBack();
      exit($e->getMessage());
    }
  }

  public function userValidate($userParams) {
    $errorMessages = array();
    if (empty($userParams['name'])) {
      $errorMessages[] = '名前を入力して下さい';
    }

    if (mb_strlen($userParams['name']) > 25) {
      $errorMessages[] = '名前は25文字以下にして下さい';
    }

    if (empty($userParams['magnification'])) {
      $errorMessages[] = '倍率を入力して下さい';
    }

    if ($userParams['magnification'] < 0 || 1 < $userParams['magnification']) {
      $errorMessages[] = '倍率は0から1の範囲で入力して下さい';
    }

    return $errorMessages;
  }
}
