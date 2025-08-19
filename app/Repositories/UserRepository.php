<?php
namespace App\Repositories;

use App\Core\Database;
use PDO;

class UserRepository
{
    public function __construct(private Database $db){}

    public function findByEmail(string $email): ?array
    {
        $stmt = $db = $this->db->pdo()->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function all(): array
    {
        return $this->db->pdo()
            ->query('SELECT id, first_name, last_name, email, phone, role FROM users ORDER BY last_name, first_name')
            ->fetchAll(PDO::FETCH_ASSOC);
    }
}
