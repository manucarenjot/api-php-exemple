<?php


namespace App\Routing;

use HomeController;

class HomeRouter extends AbstractRouter
{
    /**
     * @return void
     */
    public static function route(?string $action = null)
    {
        (new HomeController())->index();
    }
}