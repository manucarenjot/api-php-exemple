<?php

use App\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * Home page
     * @return void
     */
    public function index()
    {
        $this->render('home/index');
    }
}