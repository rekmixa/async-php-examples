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
```

### Running CLI-application

```bash
make env
php cli/sync_file_get_contents.php
php cli/async_file_get_contents.php
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
