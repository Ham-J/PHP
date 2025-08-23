<?php
namespace App\Core;

/**
 * Contrôleur de base : rendu de vues et redirections.
 */
class Controller{
    /**
     * Rend une vue en exposant les variables du tableau fourni.
     *
     * @param string               $path  Chemin relatif (ex: 'home/index')
     * @param array<string,mixed>  $data  Données à extraire pour la vue
     */
    protected function view(string $path, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        require __DIR__ . '/../Views/' . $path . '.php';
    }

    /**
     * Redirige vers une URL et termine le script.
     *
     * @param string $to URL de destination
     * @return never
     */
    protected function redirect(string $to): void
    {
        header('Location: ' . $to);
        exit;
    }
}
