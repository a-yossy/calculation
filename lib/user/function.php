<?php

function getTotalAmountOfEach($notCompletedFormerlyPurchaseRecords) {
  $totalAmountOfEach = [];
  foreach ($notCompletedFormerlyPurchaseRecords as $purchaseRecord) {
    if (array_key_exists($purchaseRecord['user_id'], $totalAmountOfEach)) {
      $totalAmountOfEach[$purchaseRecord['user_id']] += $purchaseRecord['amount_of_money'];
    } else {
      $totalAmountOfEach[$purchaseRecord['user_id']] = $purchaseRecord['amount_of_money'];
    }
  }

  return $totalAmountOfEach;
}

function getAllUsersWithAmountOfMoney($totalAmountOfEach, $users) {
  $allUsersWithAmountOfMoney = [];

  if (empty($totalAmountOfEach)) {
    foreach ($users as $user) {
        $allUsersWithAmountOfMoney[$user['name']]['magnification'] = $user['magnification'];
        $allUsersWithAmountOfMoney[$user['name']]['amount_of_money'] = 0;
    }
  } else {
    $sumOfMoney = 0;
    foreach ($totalAmountOfEach as $money) {
      $sumOfMoney += $money;
    }

    foreach ($totalAmountOfEach as $userId => $money) {
      foreach ($users as $user) {
        if ($userId == $user['id']) {
          $allUsersWithAmountOfMoney[$user['name']]['magnification'] = $user['magnification'];
          $allUsersWithAmountOfMoney[$user['name']]['amount_of_money'] = $money - $sumOfMoney * $user['magnification'];;
        }
      }
    }
  }

  return $allUsersWithAmountOfMoney;
}
