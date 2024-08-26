<?php

declare(strict_types=1);

use Clio\Console;

require __DIR__ . '/../config/bootstrap.php';

$time = microtime(true);
Console::output('Start');

$result = file_get_contents('http://localhost:80');
// потом заблокировался до тех пор,
// пока file_get_contents не вернет результат

Console::output('Do something else after ' . (microtime(true) - $time) . 's...');

Console::output('Request result: ' . $result);
Console::output('Received after: ' . (microtime(true) - $time) . 's');
