<?php

require 'vendor/autoload.php';

use Console\App\Services\DummyApiService;
use Dotenv\Dotenv;
use Dotenv\Exception\ValidationException;
use Illuminate\Database\Capsule\Manager as Capsule;


$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

try {
    $dotenv->required([
        'DB_HOST',
        'DB_PORT',
        'DB_DATABASE',
        'DB_USERNAME',
        'DB_PASSWORD'
    ])->notEmpty();
} catch (ValidationException $exception) {
    exit($exception->getMessage() . "\n");
}

$config = [
    'driver' => $_ENV['DRIVER'],
    'host' => $_ENV['DB_HOST'],
    'database' => $_ENV['DB_DATABASE'],
    'username' => $_ENV['DB_USERNAME'],
    'password' => $_ENV['DB_PASSWORD'],
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => ''
];

$capsule = new Capsule();

$capsule->addConnection($config, 'mysql');
$capsule->bootEloquent();
$capsule->getDatabaseManager()->setDefaultConnection('mysql');

$apiService = new DummyApiService($_ENV['BASE_URL']);
