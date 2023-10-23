<?php
class App
{
    // http://localhost/Quiz_online/Home/Default/1/2/3
    protected $controller = 'Home';
    protected $action = 'Default';
    protected $params = [];

    protected $routes;

    public function __construct()
    {
        $this->routes = include 'routes/routes.php';
        $url = $this->handleUrl();



        if (empty($url)) {
            $this->controller = 'Home';
        } else {
            $requestedController = $url[0];
            if (array_key_exists($requestedController, $this->routes)) {
                $this->controller = $this->routes[$requestedController]['controller'];

                if (isset($this->routes[$requestedController]['middleware'])) {
                    $this->handleMiddleware($this->routes[$requestedController]['middleware']);
                }
            } else {
                $this->controller = 'Other'; // Hoặc xử lý lỗi 404
            }
            unset($url[0]);
            // if (!empty($url[0]) && file_exists('./app/controllers/' . $url[0] . '.php')) {
            //     $this->controller = $url[0];
            //     unset($url[0]);
            // } else {
            //     $this->controller = 'Other';
            // }
        }

        require_once './app/controllers/' . $this->controller . '.php';
        $controllerInstance = new $this->controller();

        //handle actions
        if (!empty($url[1]) && method_exists($controllerInstance, $url[1])) {
            $this->action = $url[1];
            unset($url[1]);
        }

        //handle params
        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$controllerInstance, $this->action], $this->params);
    }

    protected function handleUrl()
    {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(trim($_GET['url'], '/')));
        }
    }

    protected function handleMiddleware($middlewareList)
    {
        foreach ($middlewareList as $middleware) {

            $middlewareInstance = new $middleware();
            $middlewareInstance->handle();
        }
    }
}
