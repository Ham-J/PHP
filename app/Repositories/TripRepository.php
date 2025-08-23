<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use PDO;

/**
 * Accès aux trajets (CRUD) via PDO.
 */
class TripRepository{
    /** @var PDO */
    private PDO $db;

    /**
     * @param Database $db Accès base de données
     */
    public function __construct(Database $db)
    {
        $this->db = $db->getPdo();
    }

    /**
     * Page d'accueil : trajets futurs avec places disponibles.
     *
     * @return array<int, array<string, mixed>>
     */
    public function upcomingWithAvailability(): array
    {
        $sql = "
            SELECT 
                t.id,
                t.departure_at,
                t.arrival_at,
                t.total_seats,
                t.available_seats,
                da.name AS departure,
                aa.name AS arrival,
                t.created_by_user_id
            FROM trips t
            JOIN agencies da ON t.departure_agency_id = da.id
            JOIN agencies aa ON t.arrival_agency_id = aa.id
            WHERE t.departure_at > NOW() AND t.available_seats > 0
            ORDER BY t.departure_at ASC
        ";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Liste complète (usage admin).
     *
     * @return array<int, array<string, mixed>>
     */
    public function all(): array
    {
        $sql = "
            SELECT 
                t.id,
                t.departure_at,
                t.arrival_at,
                t.total_seats,
                t.available_seats,
                t.created_by_user_id,
                da.name AS departure,
                aa.name AS arrival
            FROM trips t
            JOIN agencies da ON t.departure_agency_id = da.id
            JOIN agencies aa ON t.arrival_agency_id = aa.id
            ORDER BY t.departure_at ASC
        ";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un trajet par identifiant.
     *
     * @param int $id
     * @return array<string, mixed>|null
     */
    public function findById(int $id): ?array
    {
        $sql = "
            SELECT 
                t.*,
                da.name AS departure,
                aa.name AS arrival,
                u.first_name AS contact_first,
                u.last_name  AS contact_last,
                u.email      AS contact_email,
                u.phone      AS contact_phone
            FROM trips t
            JOIN agencies da ON t.departure_agency_id = da.id
            JOIN agencies aa ON t.arrival_agency_id  = aa.id
            JOIN users    u  ON t.contact_user_id    = u.id
            WHERE t.id = :id
            LIMIT 1
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    /**
     * Crée un trajet.
     *
     * @param array<string, mixed> $data
     * @return int ID du trajet créé
     */
    public function create(array $data): int
    {
        $sql = 'INSERT INTO trips (departure_agency_id, arrival_agency_id, departure_at, arrival_at, total_seats, available_seats, contact_user_id, created_by_user_id)
                VALUES (:dep, :arr, :d_at, :a_at, :tot, :avail, :contact, :created)';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':dep'     => $data['departure_agency_id'],
            ':arr'     => $data['arrival_agency_id'],
            ':d_at'    => $data['departure_at'],
            ':a_at'    => $data['arrival_at'],
            ':tot'     => $data['total_seats'],
            ':avail'   => $data['available_seats'],
            ':contact' => $data['contact_user_id'],
            ':created' => $data['created_by_user_id'],
        ]);
        return (int)$this->db->lastInsertId();
    }

    /**
     * Met à jour un trajet.
     *
     * @param int $id
     * @param array<string, mixed> $data
     */
    public function update(int $id, array $data): void
    {
        $sql = 'UPDATE trips SET 
                    departure_agency_id = :dep,
                    arrival_agency_id   = :arr,
                    departure_at        = :d_at,
                    arrival_at          = :a_at,
                    total_seats         = :tot,
                    available_seats     = :avail
                WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':dep'   => $data['departure_agency_id'],
            ':arr'   => $data['arrival_agency_id'],
            ':d_at'  => $data['departure_at'],
            ':a_at'  => $data['arrival_at'],
            ':tot'   => $data['total_seats'],
            ':avail' => $data['available_seats'],
            ':id'    => $id,
        ]);
    }

    /**
     * Supprime un trajet.
     *
     * @param int $id
     */
    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM trips WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }
}
