<?php

require_once('/Applications/MAMP/htdocs/calculation/classes/user.php');

function getTotalAmountOfEachByDate($formerlyPurchaseRecords) {
  $user = new User();
  $totalAmountOfEachByDate = [];

  foreach ($formerlyPurchaseRecords as $purchaseRecord) {
    $totalAmountOfEachByDate[$purchaseRecord['purchased_at']]['users'][$user->getById($purchaseRecord['user_id'])['name']]
      = $purchaseRecord['amount_of_money'];
    $totalAmountOfEachByDate[$purchaseRecord['purchased_at']]['is_completed']
      = $purchaseRecord['is_completed'];
    if (array_key_exists('purchase_record_ids', $totalAmountOfEachByDate[$purchaseRecord['purchased_at']])) {
      $totalAmountOfEachByDate[$purchaseRecord['purchased_at']]['purchase_record_ids'][]
      = $purchaseRecord['id'];
    } else {
      $totalAmountOfEachByDate[$purchaseRecord['purchased_at']]['purchase_record_ids']
      = [$purchaseRecord['id']];
    }
  }

  return $totalAmountOfEachByDate;
}
