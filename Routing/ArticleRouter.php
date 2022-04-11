<?php

namespace App\Routing;

use App\Controller\ArticleController;
use ErrorController;

class ArticleRouter extends AbstractRouter
{
    public static function route(?string $action = null)
    {
        $errorController = new ErrorController();
        $controller = new ArticleController();

        if(null === $action) {
            $errorController->error404($action);
        }

        switch ($action) {
            case 'index':
                $controller->index();
                break;
            case 'list-all-articles':
                $controller->listAllArticles();
                break;
            case 'add-article':
                $controller->addArticle();
                break;
            default:
                $errorController->error404($action);
        }
    }
}