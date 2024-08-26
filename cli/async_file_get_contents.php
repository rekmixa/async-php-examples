<?php

declare(strict_types=1);

use Clio\Console;

require __DIR__ . '/../config/bootstrap.php';

$time = microtime(true);
Console::output('Start');

$fp = stream_socket_client('tcp://localhost:80');
stream_set_blocking($fp, false);

fwrite($fp, "GET / HTTP/1.0\r\nAccept: */*\r\n\r\n");

Console::output('Do something else after ' . (microtime(true) - $time) . 's...');
// в этот момент запрос уже ушёл, но поток не заблокировался

$response = '';
while (!feof($fp)) {
    $response .= fgets($fp, 1024);
    // а прочитать результат выполнения запроса мы можем по-позже
}

[$headers, $body] = explode("\r\n\r\n", $response, 2);

fclose($fp);

Console::output('Request result: ' . $body);
Console::output('Received after: ' . (microtime(true) - $time) . 's');
