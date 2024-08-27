<?php

declare(strict_types=1);

use Clio\Console;

require __DIR__ . '/../config/bootstrap.php';

$time = microtime(true);

co::run(static function () use ($time): void {
    go(static function () use ($time): void {
//        Co::sleep(1);
        sleep(1); // даже с использованием блокирующей функции sleep, обе корутины завершили свое выполнение одновременно!
        Console::output('Done 1: ' . (microtime(true) - $time));
    });

    go(static function () use ($time): void {
//        Co::sleep(1);
        sleep(1);
        Console::output('Done 2: ' . (microtime(true) - $time));
    });
});
