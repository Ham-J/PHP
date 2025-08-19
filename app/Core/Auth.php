<?php
namespace App\Core;

use App\Repositories\UserRepository;

class Auth
{
    public function __construct(private UserRepository $users)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function attempt(string $email, string $password): bool
    {
        $user = $this->users->findByEmail($email);
        if (!$user) return false;
        if (!password_verify($password, $user['password_hash'])) return false;
        $_SESSION['uid'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        return true;
    }

    public function logout(): void
    {
        $_SESSION = [];
        session_destroy();
    }

    public function check(): bool
    {
        return isset($_SESSION['uid']);
    }

    public function id(): ?int
    {
        return $_SESSION['uid'] ?? null;
    }

    public function isAdmin(): bool
    {
        return ($_SESSION['role'] ?? '') === 'admin';
    }
}
