<?php

namespace task2\config;

use PDO;

class Db extends PDO
{
    public function __construct()
    {
        parent::__construct('mysql:host=localhost;dbname=budget', 'root', '');
    }
}