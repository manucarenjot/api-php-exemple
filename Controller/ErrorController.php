<?php

class ErrorController
{
    /**
     * Control the error page.
     * @param string $askPage
     * @return void
     */
    public function error404(string $askPage)
    {
        require __DIR__ . '/../View/error/404.html.php';
    }


    /**
     * Display an error on missed functions parameters.
     * @return void
     */
    public function missingParameters()
    {
        require __DIR__ . '/../View/error/missing-parameters.html.php';
    }
}