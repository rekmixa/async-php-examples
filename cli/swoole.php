<?php

declare(strict_types=1);

require __DIR__ . '/../config/bootstrap.php';

co::run(static function (): void {
    go(static function (): void {
        Co::sleep(1);
        echo "Done 1\n";
    });

    go(static function () {
        Co::sleep(1);
        echo "Done 2\n";
    });
});
