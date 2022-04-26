<?php

function getTotalAmountOfEach($purchaseRecords) {
  $totalAmountOfEach = [];
  foreach ($purchaseRecords as $purchaseRecord) {
    if (array_key_exists($purchaseRecord['user_id'], $totalAmountOfEach)) {
      $totalAmountOfEach[$purchaseRecord['user_id']] += $purchaseRecord['amount_of_money'];
    } else {
      $totalAmountOfEach[$purchaseRecord['user_id']] = $purchaseRecord['amount_of_money'];
    }
  }

  return $totalAmountOfEach;
}

function getAllUsersWithAmountOfMoney($totalAmountOfEach, $allUsers) {
  $allUsersWithAmountOfMoney = [];
  foreach ($totalAmountOfEach as $userId => $money) {
    foreach ($allUsers as $user) {
      if ($userId == $user['id']) {
        $allUsersWithAmountOfMoney[$user['name']]['magnification'] = $user['magnification'];
        $allUsersWithAmountOfMoney[$user['name']]['amount_of_money'] = $money;
      }
    }
  }

  return $allUsersWithAmountOfMoney;
}
