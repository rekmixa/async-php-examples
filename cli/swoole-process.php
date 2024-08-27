<?php

declare(strict_types=1);

use Clio\Console;
use OpenSwoole\Process;

require __DIR__ . '/../config/bootstrap.php';

$time = microtime(true);

$process1 = new Process(function (Process $worker) use ($time): void {
    Console::output('pid: ' . $worker->pid);
    $worker->write('executing request...' . PHP_EOL);
    $result = file_get_contents('http://localhost:81');
    $worker->write('Result 1: ' . $result . PHP_EOL);
    $worker->write('Result received after ' . (microtime(true) - $time) . 's' . PHP_EOL);
}, false);

$process2 = new Process(function (Process $worker) use ($time): void {
    Console::output('pid: ' . $worker->pid);
    $worker->write('executing request...' . PHP_EOL);
    $result = file_get_contents('http://localhost:81');
    $worker->write('Result 1: ' . $result . PHP_EOL);
    $worker->write('Result received after ' . (microtime(true) - $time) . 's' . PHP_EOL);
}, false);

$process1->start();
$process2->start();

while (true) {
    echo $process1->read();
    echo $process2->read();
}
