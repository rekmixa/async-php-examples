<?php

declare(strict_types=1);

use function Amp\async;
use function Amp\delay;

require __DIR__ . '/../config/bootstrap.php';

$future1 = async(function () {
    echo 'Hello ';
    delay(2);
    echo 'the future! ';
});

$future2 = async(function () {
    echo 'World ';
    delay(1);
    echo 'from ';
});

echo "Let's start: ";

$future1->await();
$future2->await();

echo PHP_EOL;
