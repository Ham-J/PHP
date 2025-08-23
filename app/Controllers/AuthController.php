<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;

/**
 * Contrôleur d'authentification (affichage form, login, logout).
 */
class AuthController extends Controller
{
    public function __construct(private Auth $auth){}

    /** Affiche le formulaire de connexion. */
    public function showLogin(): void
    {
        $this->view('auth/login');
    }

    /** Traite la soumission du formulaire de connexion. */
    public function login(): void
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        if ($this->auth->attempt($email, $password)) {
            $this->redirect('/');
        }
        $this->view('auth/login', ['error' => 'Invalid credentials']);
    }

    /** Déconnecte l'utilisateur puis redirige vers l'accueil. */
    public function logout(): void
    {
        $this->auth->logout();
        $this->redirect('/');
    }
}
