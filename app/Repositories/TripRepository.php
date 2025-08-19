<?php
namespace App\Repositories;

use App\Core\Database;
use PDO;

class TripRepository
{
    public function __construct(private Database $db){}

    public function upcomingWithAvailability(): array
    {
        $sql = 'SELECT t.*, 
                       adep.name AS dep_name, aarr.name AS arr_name,
                       u.first_name, u.last_name, u.email, u.phone
                FROM trips t
                JOIN agencies adep ON adep.id = t.departure_agency_id
                JOIN agencies aarr ON aarr.id = t.arrival_agency_id
                JOIN users u ON u.id = t.contact_user_id
                WHERE t.available_seats > 0 AND t.departure_at >= NOW()
                ORDER BY t.departure_at ASC';
        return $this->db->pdo()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}
