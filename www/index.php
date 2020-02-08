<?php declare(strict_types = 1);

require __DIR__ . '/../vendor/autoload.php';
ini_set('serialize_precision', ini_get('precision'));

define('WWW_DIR', dirname(__DIR__) . '/www');
define('APP_DIR', dirname(__DIR__) . '/App');
define('LIBS_DIR', dirname(__DIR__) . '/Libs');

App\Bootstrap::boot()
    ->createContainer()
    ->getByType(Nette\Application\Application::class)
    ->run();
