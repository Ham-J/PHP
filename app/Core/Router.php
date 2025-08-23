<?php
namespace App\Core;

/**
 * Router minimaliste GET/POST basé sur un mapping en mémoire.
 */
class Router{
    /** @var array<string, callable> */
    private array $get = [];
    /** @var array<string, callable> */
    private array $post = [];

    /**
     * Enregistre un handler pour une route GET.
     *
     * @param string   $path    Chemin (ex: "/login")
     * @param callable $handler Closure contrôleur
     */
    public function get(string $path, callable $handler): void
    {
        $this->get[$path] = $handler;
    }

    /**
     * Enregistre un handler pour une route POST.
     *
     * @param string   $path    Chemin (ex: "/login")
     * @param callable $handler Closure contrôleur
     */
    public function post(string $path, callable $handler): void
    {
        $this->post[$path] = $handler;
    }

    /**
     * Résout et exécute le handler correspondant.
     *
     * @param string $method Méthode HTTP (GET|POST)
     * @param string $path   Chemin demandé
     */
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
