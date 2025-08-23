<?php
use PHPUnit\Framework\TestCase;
use app\Core\Database;
use app\Repositories\TripRepository;

class TripRepositoryTest extends TestCase
{
    private TripRepository $repo;

    protected function setUp(): void
    {
        // ⚠️ Utilise une base de test ou SQLite mémoire
        $db = new Database(['dsn' => 'sqlite::memory:']);
        $pdo = $db->getPdo();

        // créer la table minimale pour tester
        $pdo->exec("
            CREATE TABLE trips (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                departure_agency_id INT,
                arrival_agency_id INT,
                departure_at TEXT,
                arrival_at TEXT,
                total_seats INT,
                available_seats INT,
                contact_user_id INT,
                created_by_user_id INT
            )
        ");

        $this->repo = new TripRepository($db);
    }

    public function testCreateTrip(): void
    {
        $data = [
            'departure_agency_id' => 1,
            'arrival_agency_id'   => 2,
            'departure_at'        => '2025-08-30 12:00:00',
            'arrival_at'          => '2025-08-30 14:00:00',
            'total_seats'         => 10,
            'available_seats'     => 10,
            'contact_user_id'     => 1,
            'created_by_user_id'  => 1,
        ];

        $this->repo->create($data);

        $trips = $this->repo->all();
        $this->assertCount(1, $trips);
        $this->assertEquals(10, $trips[0]['total_seats']);
    }
}
