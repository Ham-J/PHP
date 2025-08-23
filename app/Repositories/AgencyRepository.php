<?php
namespace App\Repositories;

use App\Core\Database;
use PDO;

/**
 * Accès et gestion des agences (CRUD admin).
 */
class AgencyRepository{
    public function __construct(private Database $db){}

    /** @return array<int, array<string, mixed>> */
    public function all(): array
    {
        return $this->db->getPdo()
            ->query('SELECT * FROM agencies ORDER BY name')
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Crée une agence et retourne son ID. */
    public function create(string $name): int
    {
        $stmt = $this->db->getPdo()->prepare('INSERT INTO agencies (name) VALUES (:n)');
        $stmt->execute([':n' => $name]);
        return (int)$this->db->getPdo()->lastInsertId();
    }

    /** Met à jour le nom d'une agence. */
    public function update(int $id, string $name): void
    {
        $stmt = $this->db->getPdo()->prepare('UPDATE agencies SET name = :n WHERE id = :id');
        $stmt->execute([':n' => $name, ':id' => $id]);
    }

    /** Supprime une agence. */
    public function delete(int $id): void
    {
        $stmt = $this->db->getPdo()->prepare('DELETE FROM agencies WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }
}
