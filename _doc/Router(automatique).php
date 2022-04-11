<?php

namespace App;

use App\Controller\AbstractController;
use ErrorController;
use ReflectionMethod;

class Router
{
    /**
     * Route the request.
     * @return void
     * @throws \ReflectionException
     */
    public static function route()
    {
        $controllerStr = self::getParam('c', 'home');
        $action = self::getParam('a');
        $controller = self::guessController($controllerStr);

        // Display a 404 message if controller cannot be guessed.
        if ($controller instanceof ErrorController) {
            $controller->error404($controllerStr);
            exit();
        }

        // Ici, on est certain d'avoir un controller.
        $action = self::guessMethod($controller, $action);
        if(null === $action) {
            $controller->index();
        }
        else {
            $parameters = self::guessParams($controller, $action);
            if(count($parameters) === 0 ) {
                $controller->$action();
            }
            else {
                $params = [];
                foreach ($parameters as $p) {
                    $var = $_GET[$p['param']];
                    settype($var, $p['type']);
                    $params[] = $var;
                }
                $controller->$action(...$params);
            }
        }
    }


    /**
     * Try to guess the controller to be used.
     * @param string $controller
     * @return ErrorController|mixed
     */
    private static function guessController(string $controller)
    {
        $controller = ucfirst($controller) . 'Controller';
        if (class_exists($controller)) {
            return new $controller();
        }
        return new ErrorController();
    }


    /**
     * @param AbstractController $controller
     * @param string|null $action
     * @return string|null
     */
    private static function guessMethod(AbstractController $controller, ?string $action)
    {
        if (strpos($action, '-') !== -1) {
            $action = array_reduce(explode('-', $action), function ($ac, $a) {
                return $ac . ucfirst($a);
            });
        }

        $action = lcfirst($action);
        return method_exists($controller, $action) ? $action : null;
    }


    /**
     * @param AbstractController $controller
     * @param string $action
     * @return array
     * @throws \ReflectionException
     */
    private static function guessParams(AbstractController $controller, string $action): array
    {
        $paramsArray = [];
        $reflexion = new ReflectionMethod($controller, $action);
        $parameters = $reflexion->getParameters();
        foreach ($parameters as $param) {
            $paramsArray[] = [
                'param' => $param->name,
                'type' => $param->getType(),
            ];
        }
        return $paramsArray;
    }


    /**
     * Get param from $_GET superglobale.
     * @param string $key
     * @param null $default
     * @return string|null
     */
    private static function getParam(string $key, $default = null): ?string
    {
        if (isset($_GET[$key])) {
            return filter_var($_GET[$key], FILTER_SANITIZE_STRING);
        }

        return $default;
    }
}