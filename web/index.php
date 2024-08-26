<?php

declare(strict_types=1);

require __DIR__ . '/../config/bootstrap.php';

header('Content-Type: application/json');

sleep(5);

echo json_encode([
    'success' => true,
]);
