<?php

// утрированный пример реализации EventLoop на PHP

declare(strict_types=1);

use Clio\Console;

require __DIR__ . '/../config/bootstrap.php';

final class EventLoop
{
    /**
     * @var resource[]
     */
    private static array $sockets = [];

    /**
     * @var Promise[]
     */
    private static array $promises = [];

    /**
     * @param resource $socket
     * @param Promise $promise
     */
    public static function addSocket($socket, Promise $promise): void
    {
        self::$sockets[] = $socket;
        self::$promises[] = $promise;
    }

    public static function run(): void
    {
        foreach (self::$sockets as $i => $socket) {
            $promise = self::$promises[$i];
            $response = '';
            while (!feof($socket)) {
                $response .= fgets($socket, 1024);
            }

            [, $body] = explode("\r\n\r\n", $response, 2);

            $promise->resolve($body);
        }
    }
}

final class Promise
{
    private array $callbacks = [];

    public function then(callable $callback): self
    {
        $this->callbacks[] = $callback;

        return $this;
    }

    public function resolve(string $body): void
    {
        $nextResult = $body;

        foreach ($this->callbacks as $callback) {
            $callback($nextResult);
            $nextResult = $body;
        }
    }
}

final class RequestSender
{
    public static function sendRequest(string $url): Promise
    {
        $socket = stream_socket_client($url);
        stream_set_blocking($socket, false);
        fwrite($socket, "GET / HTTP/1.0\r\nAccept: */*\r\n\r\n");

        $promise = new Promise();
        EventLoop::addSocket($socket, $promise);

        return $promise;
    }
}

$time = microtime(true);
Console::output('Start');

$promise1 = RequestSender::sendRequest('tcp://localhost:80');
$promise2 = RequestSender::sendRequest('tcp://localhost:80');
$promise3 = RequestSender::sendRequest('tcp://localhost:80');

Console::output('Do something else after ' . (microtime(true) - $time) . 's...');

$promise1->then(static function (string $body) use ($time): void {
    Console::output('Promise 1 result: ' . $body);
    Console::output('Received after: ' . (microtime(true) - $time) . 's');
});

$promise2->then(static function (string $body) use ($time): void {
    Console::output('Promise 2 result: ' . $body);
    Console::output('Received after: ' . (microtime(true) - $time) . 's');
});

$promise3->then(static function (string $body) use ($time): void {
    Console::output('Promise 3 result: ' . $body);
    Console::output('Received after: ' . (microtime(true) - $time) . 's');
});

EventLoop::run();
