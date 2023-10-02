<?php

namespace task2\api;

use task2\entities\Budget;
use task2\entities\Transaction;

class ApiController
{
    public function topUpBalance(int | float $sum) : void
    {

        if (empty($sum)) {
            echo json_encode('Не указана сумма.');
        } else {
            Budget::changeBalance($sum);
            echo json_encode('Баланс изменён');
        }
    }

    public function withdrawFromBalance(int | float $sum) : void
    {
        if (empty($sum)) {
            echo json_encode('Не указана сумма.');
        } else {
            if ($sum > 0) {
                $sum = -$sum;
            }
            Budget::changeBalance($sum);
            echo json_encode('Баланс изменён');
        }
    }

    public function checkBalance() : void
    {
        echo json_encode(Budget::getBalance());
    }

    public function getTransactions() : void
    {
        echo json_encode(Transaction::getAll());
    }
}