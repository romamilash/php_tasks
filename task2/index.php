<?php
require_once 'core/bootstrap.php';
?>
<p>
    Сумма:
    <input type="number" id="sum">
</p>
<button onclick="topBalance()">Пополнить</button>
<button onclick="withdrawBalance()">Снять</button>

<button id="check">Проверить баланс</button>
<button id="list">Список транзакций</button>

<hr>

<div></div>

<script src="js/main.js"></script>
