<?php declare(strict_types = 1);

namespace App\Router;

use Nette;
use Nette\Application\Routers\RouteList;
use Nette\Routing\Route;

final class RouterFactory
{

    use Nette\StaticClass;

    public static function createRouter(): RouteList
    {
        $router = new RouteList;
        $router->addRoute('/obnova-hesla', 'Homepage:reset');
        $router->addRoute('<presenter>/<action>', 'Homepage:default');
        return $router;
    }
}
