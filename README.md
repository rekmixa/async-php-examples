# async-php-examples

## Install

```bash
make install
```

## Setup

```bash
make
```

## Composer

```bash
make composer-install
```

### Start PHP-server

```bash
make env
cd web
php -S localhost:80
php -S localhost:80 > /dev/null 2>&1 &
php -S localhost:81
php -S localhost:81 > /dev/null 2>&1 &
```

### Start AMPHP-server

```bash
make env
php web/amphp-server.php
```

### Running CLI-application

```bash
make env
php cli/sync_file_get_contents.php
php cli/async_file_get_contents.php
php cli/amphp.php
php cli/swoole.php
php cli/swoole-process.php
```

## Running tests

```bash
make env
vendor/bin/phpunit tests
```

## Running mutation tests

```bash
make env-root
vendor/bin/infection --threads=4
```
