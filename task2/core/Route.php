<?php

namespace task2\core;

use task2\api\ApiController;

class Route
{
    public static function run()
    {
        if (!$_SERVER['REQUEST_URI'] == '/index.php') {
            $routes = explode('/', $_SERVER['REQUEST_URI']);

            if (!empty($routes[1])) {
                $action_name = $routes[1];
            }

            if (!empty($routes[2])) {
                $sum = $routes[2];
            }

            $controller = new ApiController();
            $action = $action_name;

            if (method_exists($controller, $action)) {
                $controller->$action($sum);
            } else {
                Route::ErrorPage404();
            }
        }
    }

    private static function ErrorPage404()
    {
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:' . $host . '404');
    }
}