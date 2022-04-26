<?php

require_once('../../classes/user.php');

function getTotalAmountOfEachByDate($formerlyPurchaseRecords) {
  $user = new User();
  $totalAmountOfEachByDate = [];

  foreach ($formerlyPurchaseRecords as $purchaseRecord) {
    $totalAmountOfEachByDate[$purchaseRecord['purchased_at']][$user->getById($purchaseRecord['user_id'])['name']]
      = $purchaseRecord['amount_of_money'];
  }

  return $totalAmountOfEachByDate;
}
