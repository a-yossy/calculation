<?php

require_once('/Applications/MAMP/htdocs/calculation/classes/user.php');

function getTotalAmountOfEachByDate($formerlyPurchaseRecords) {
  $user = new User();
  $totalAmountOfEachByDate = [];

  foreach ($formerlyPurchaseRecords as $purchaseRecord) {
    if (!empty($totalAmountOfEachByDate[$purchaseRecord['purchased_at']]) && array_key_exists($user->getById($purchaseRecord['user_id'])['name'], $totalAmountOfEachByDate[$purchaseRecord['purchased_at']]['users'])) {
      $totalAmountOfEachByDate[$purchaseRecord['purchased_at']]['users'][$user->getById($purchaseRecord['user_id'])['name']]
        += $purchaseRecord['amount_of_money'];
    } else {
      $totalAmountOfEachByDate[$purchaseRecord['purchased_at']]['users'][$user->getById($purchaseRecord['user_id'])['name']]
        = $purchaseRecord['amount_of_money'];
    }
  }
  return $totalAmountOfEachByDate;
}
