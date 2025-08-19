<?php
namespace App\Core;

abstract class Controller
{
    protected function view(string $template, array $vars = []): void
    {
        View::render($template, $vars);
    }

    protected function redirect(string $path): void
    {
        header('Location: ' . $path);
        exit;
    }
}
