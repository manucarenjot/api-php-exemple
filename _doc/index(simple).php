<?php

use App\Controller\AbstractController;
use App\Controller\ArticleController;

require __DIR__ . '/../includes.php';

$page = secure($_GET['c']) ?? 'home';
$method = secure($_GET['a']) ?? 'index';

// Defining the right controller.
switch ($page) {
    case 'home':
        (new HomeController())->index();
        break;
    case 'user':
        user($method);
        break;
    case 'article':
        article($method);
        break;
    default:
        (new ErrorController())->error404($page);
}


/**
 * Manage Usercontroller routes.
 * @param string $action
 * @return void
 */
function user(string $action)
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
            execRouteWithParameters($controller, 'showUser', ['id' => 'int']);
            break;
        case 'edit-user':
            execRouteWithParameters($controller, 'editUser', ['id' => 'int', 'category' => 'string']);
            break;
        case 'delete-user':
            execRouteWithParameters($controller, 'deleteUser', ['id' => 'int']);
            break;
        default:
            (new ErrorController())->error404($action);
    }
}


/**
 * @param AbstractController $controller
 * @param string $method
 * @param array $params
 * @return void
 */
function execRouteWithParameters(AbstractController $controller, string $method, array $params): void
{
    $args = [];
    foreach ($params as $param => $type) {
        if(!isset($_GET[$param])) {
            (new ErrorController())->missingParameters();
            return;
        }

        $arg = secure($_GET[$param]);
        settype($arg, $type);
        $args[] = $arg;
    }

    $controller->$method(...$args);
}


/**
 * Manage ArticleController routes.
 * @param string $action
 * @return void
 */
function article(string $action)
{
    $controller = new ArticleController();
    switch ($action) {
        case 'index':
            $controller->index();
        case 'list-all-articles':
            $controller->listAllArticles();
        default:
            (new ErrorController())->error404($action);
    }
}


/**
 * Remove potentially unsecured things.
 * @param string|null $param
 * @return string
 */
function secure(?string $param): ?string
{
    if(null === $param) {
        return null;
    }

    $param = strip_tags($param);
    $param =  trim($param);
    return strtolower($param);
}