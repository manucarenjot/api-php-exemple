<?php

namespace App\Routing;

use App\Controller\API\ArticleController;

class ApiRouter extends AbstractRouter
{

    public static function route(?string $action = null)
    {
        switch($action)
        {
            case 'add-article':
                (new ArticleController())->addArticle();
                break;
            default:
                // 404 = Not Found.
                http_response_code(404);
        }

        exit;
    }
}