<?php
namespace App\Core;
use PDO;

/**
 * Petite couche d'accès PDO centralisée.
 */
class Database{
    /** @var PDO */
    private PDO $pdo;

    /**
     * @param array{dsn:string,user:string,pass:string} $config Configuration PDO
     */
    public function __construct(array $config)
    {
        $this->pdo = new PDO(
            $config['dsn'],
            $config['user'],
            $config['pass'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );
    }

    /**
     * Retourne l'instance PDO brute.
     *
     * @return PDO
     */
    public function getPdo(): PDO
    {
        return $this->pdo;
    }
}
