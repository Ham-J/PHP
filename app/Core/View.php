<?php
namespace App\Core;

class View
{
    public static function render(string $template, array $vars = []): void
    {
        extract($vars);
        include __DIR__ . '/../Views/' . $template . '.php';
    }
}
