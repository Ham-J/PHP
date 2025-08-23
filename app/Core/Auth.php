<?php
namespace App\Core;

use App\Repositories\UserRepository;

/**
 * Gestion d'authentification très simple basée sur la session.
 */
class Auth{
    public function __construct(private UserRepository $users)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Tente une connexion utilisateur.
     *
     * @param string $email
     * @param string $password Mot de passe en clair à vérifier
     * @return bool True si authentifié
     */
    public function attempt(string $email, string $password): bool
    {
        $user = $this->users->findByEmail($email);
        if (!$user) {
            return false;
        }
        if (!password_verify($password, $user['password_hash'])) {
            return false;
        }
        $_SESSION['uid'] = (int)$user['id'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name']  = $user['last_name'];
        $_SESSION['role'] = $user['role'];
        return true;
    }

    /** Déconnecte l'utilisateur courant. */
    public function logout(): void
    {
        $_SESSION = [];
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }

    /** @return bool True si un utilisateur est connecté */
    public function check(): bool
    {
        return isset($_SESSION['uid']);
    }

    /** @return int|null Identifiant de l'utilisateur connecté */
    public function id(): ?int
    {
        return $_SESSION['uid'] ?? null;
    }

    /** @return bool True si l'utilisateur connecté a le rôle admin */
    public function isAdmin(): bool
    {
        return ($_SESSION['role'] ?? '') === 'admin';
    }
}
