<?php
namespace App\Repositories;

use App\Core\Database;
use PDO;

/**
 * Accès aux utilisateurs (lecture principalement).
 */
class UserRepository{
    public function __construct(private Database $db){}

    /**
     * Trouve un utilisateur via son email.
     *
     * @param string $email
     * @return array<string, mixed>|null
     */
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->getPdo()->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    /**
     * Liste tous les utilisateurs.
     *
     * @return array<int, array<string, mixed>>
     */
    public function all(): array
    {
        return $this->db->getPdo()
            ->query('SELECT id, first_name, last_name, email, phone, role FROM users ORDER BY last_name, first_name')
            ->fetchAll(PDO::FETCH_ASSOC);
    }
}
