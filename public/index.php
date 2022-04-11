<?php

use App\Routing\AbstractRouter;
use App\Routing\ApiRouter;
use App\Routing\ArticleRouter;
use App\Routing\HomeRouter;
use App\Routing\UserRouter;


require __DIR__ . '/../includes.php';
session_start();

$page = AbstractRouter::secure($_GET['c']) ?? 'home';
$method = AbstractRouter::secure($_GET['a']) ?? 'index';

// Defining the right controller.
switch ($page) {
    case 'home':
        HomeRouter::route();
        break;
    case 'user':
        UserRouter::route($method);
        break;
    case 'article':
        ArticleRouter::route($method);
        break;
    case 'api':
        // Prise en charge du cas ou on a recu un appel API
        ApiRouter::route($method);
        break;
    default:
        (new ErrorController())->error404($page);
}
