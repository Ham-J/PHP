<?php
namespace App\Repositories;

use App\Core\Database;
use PDO;

class AgencyRepository
{
    public function __construct(private Database $db){}

    public function all(): array
    {
        return $this->db->pdo()
            ->query('SELECT * FROM agencies ORDER BY name')
            ->fetchAll(PDO::FETCH_ASSOC);
    }
}
