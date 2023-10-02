<?php

namespace task2\entities;

use task2\config\Db;

class Budget
{
    private static Db $db;
    public static function changeBalance(int | float $sum) : void
    {
        try {
            self::$db->beginTransaction();
            $time = time();
            self::$db->prepare("UPDATE `balance` SET `balance` = {$sum}")->execute();
            self::$db->prepare("INSERT INTO `transaction` VALUES (1, {$sum}, {$time})")->execute();

            self::$db->commit();
        } catch (\Throwable $e) {
            $db->rollback();
            throw $e;
        }
    }

    public static function getBalance()
    {
        return self::$db->query("SELECT `balance` FROM `budget`")->fetch();
    }
}