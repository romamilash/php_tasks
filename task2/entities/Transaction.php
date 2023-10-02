<?php

namespace task2\entities;

use task2\config\Db;

class Transaction
{
    private static Db $db;
    public static function getAll()
    {
        return self::$db->query("SELECT `balance` FROM `transaction`")->fetch();
    }
}