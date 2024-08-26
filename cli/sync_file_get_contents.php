<?php

declare(strict_types=1);

use Clio\Console;

require __DIR__ . '/../config/bootstrap.php';

Console::output('Start: ' . microtime(true));

$result = file_get_contents('http://localhost:80');

Console::output('Do something else... ' . microtime(true));

Console::output('Request result: ' . $result);

Console::output('Finish: ' . microtime(true));
