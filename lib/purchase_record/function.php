<?php

function getTotalAmountOfEachByDate($formerlyPurchaseRecords) {
  $totalAmountOfEachByDate = [];

  foreach ($formerlyPurchaseRecords as $purchaseRecord) {
    if (!empty($totalAmountOfEachByDate[$purchaseRecord['purchased_at']]) && array_key_exists($purchaseRecord['user_id'], $totalAmountOfEachByDate[$purchaseRecord['purchased_at']]['users'])) {
      $totalAmountOfEachByDate[$purchaseRecord['purchased_at']]['users'][$purchaseRecord['user_id']]
        += $purchaseRecord['amount_of_money'];
    } else {
      $totalAmountOfEachByDate[$purchaseRecord['purchased_at']]['users'][$purchaseRecord['user_id']]
        = $purchaseRecord['amount_of_money'];
    }
  }
  return $totalAmountOfEachByDate;
}
