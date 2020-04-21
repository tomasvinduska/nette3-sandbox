<?php declare(strict_types = 1);

namespace App;

use Nette\Configurator;

class Bootstrap
{

    public static function bootForTests(): Configurator
    {
        $configurator = self::boot();
        \Tester\Environment::setup();
        return $configurator;
    }

    public static function boot(): Configurator
    {
        $configurator = new Configurator();

        if (PHP_SAPI === 'cli') {
            $configurator->setDebugMode(true);
        } else {
            $configurator->setDebugMode(['127.0.0.1', '192.168.10.1', '']);
        }

        $configurator->enableTracy(__DIR__ . '/../log');

        $configurator->setTimeZone('Europe/Prague');
        $configurator->setTempDirectory(__DIR__ . '/../temp');

        $configurator->addConfig(__DIR__ . '/Config/config.neon');
        $local_neon = __DIR__ . '/Config/config.local.neon';
        if (file_exists($local_neon)) {
            $configurator->addConfig($local_neon);
        }
        $configurator->addParameters(
            [
                'MODE' => getenv('MODE'),
                'PAYGATE_API_KEY_DEFAULT' => getenv('PAYGATE_API_KEY_DEFAULT'),
                'PAYGATE_API_KEY_CSOB' => getenv('PAYGATE_API_KEY_CSOB'),
                'gaAccount' => getenv('GA_ACCOUNT'),
                'smartlook' => getenv('SMARTLOOK'),
                'THEME' => getenv('THEME'),
                'THEME_ADMIN' => getenv('THEME_ADMIN'),
                'themeDir' => APP_DIR . '/Themes/%THEME%/Assets/',
                'themeAdminDir' => APP_DIR . '/Themes/%THEME_ADMIN%/Assets/',
                'wwwDir' => WWW_DIR,
                'appDir' => APP_DIR,
            ]
        );

        return $configurator;
    }

}
