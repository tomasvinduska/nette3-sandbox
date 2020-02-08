<?php declare(strict_types = 1);

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../App/constants.php';

ini_set('serialize_precision', ini_get('precision'));

try {
    \App\Bootstrap::boot()
        ->createContainer()
        ->getByType(\Nette\Application\Application::class)
        ->run();
} catch (Throwable $e) {
    echo $e->getMessage();
}
