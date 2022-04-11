<?php

namespace App\Routing;

use ErrorController;
use UserController;

class UserRouter extends AbstractRouter
{

    public static function route(?string $action = null)
    {
        $controller = new UserController();
        switch ($action) {
            case 'index':
                $controller->index();
                break;
            case 'show-stats':
                $controller->showStats();
                break;
            case 'show-user':
                self::execRouteWithParameters($controller, 'showUser', ['id' => 'int']);
                break;
            case 'edit-user':
                self::execRouteWithParameters($controller, 'editUser', ['id' => 'int', 'category' => 'string']);
                break;
            case 'delete-user':
                self::execRouteWithParameters($controller, 'deleteUser', ['id' => 'int']);
                break;
            case 'register':
                $controller->register();
                break;
            case 'logout':
                $controller->logout();
                break;
            case 'login':
                $controller->login();
                break;
            default:
                (new ErrorController())->error404($action);
        }
    }
}