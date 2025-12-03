<?php

namespace XXJ\Core;

class Router
{
    private array $routes = [];
    private $notFoundHandler;

    public function add(string $cmd, callable|array $handler): void
    {
        $this->routes[$cmd] = $handler;
    }

    public function dispatch(string $cmd, array $params = [])
    {
        if (isset($this->routes[$cmd])) {
            $handler = $this->routes[$cmd];
            if (is_array($handler)) {
                [$controller, $method] = $handler;
                $instance = new $controller();
                return call_user_func([$instance, $method], $params);
            }
            return call_user_func($handler, $params);
        }

        if ($this->notFoundHandler) {
            return call_user_func($this->notFoundHandler, $cmd);
        }

        throw new \Exception("Command not found: $cmd");
    }

    public function setNotFoundHandler(callable $handler): void
    {
        $this->notFoundHandler = $handler;
    }
}
