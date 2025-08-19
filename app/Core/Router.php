<?php
namespace App\Core;

class Router
{
    private array $get = [];
    private array $post = [];

    public function get(string $path, callable $handler): void
    {
        $this->get[$path] = $handler;
    }

    public function post(string $path, callable $handler): void
    {
        $this->post[$path] = $handler;
    }

    public function dispatch(string $method, string $path): void
    {
        $table = strtoupper($method) === 'POST' ? $this->post : $this->get;
        $handler = $table[$path] ?? null;
        if (!$handler) {
            http_response_code(404);
            echo 'Not Found';
            return;
        }
        $handler();
    }
}
