<?php

namespace App\Core;

use App\Traits\Singleton;
use PDO;
use PDOException;

class Database
{
    use Singleton;

    private ?PDO $conn = null;

    private function __construct()
    {
        $this->connect();
    }

    private function connect(): void
    {
        $host = env('DB_HOST');
        $port = env('DB_PORT', 3306);
        $dbname = env('DB_NAME');
        $username = env('DB_USER');
        $password = env('DB_PASSWORD');
        $charset = env('DB_CHARSET', 'utf8mb4');

        $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset={$charset}";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Throw exceptions on errors
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,        // Fetch associative arrays by default
            PDO::ATTR_EMULATE_PREPARES   => false,                   // Use real prepared statements
        ];

        try {
            $this->conn = new PDO($dsn, $username, $password, $options);
        } catch (PDOException $e) {
            throw new \Exception("DATABASE CONNECTION FAILED: " . $e->getMessage(), 1);
        }
    }

    public function getConnection(): PDO
    {
        return $this->conn;
    }

    /**
     * Execute a SELECT query and return all results.
     *
     * @param string $query The SQL query (should be a SELECT)
     * @param array $params Optional parameters for prepared statements
     * @return array
     */
    public function getResultsByQuery(string $query, array $params = []): array
    {
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new \Exception("QUERY FAILED: {$e->getMessage()}\nSQL: {$query}", 1);
        }
    }

    /**
     * Execute an INSERT, UPDATE, DELETE, or other non-SELECT query.
     *
     * @param string $query The SQL query
     * @param array $params Optional parameters for prepared statements
     * @return bool
     */
    public function onlyExecuteQuery(string $query, array $params = []): bool
    {
        try {
            $stmt = $this->conn->prepare($query);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            throw new \Exception("QUERY FAILED: {$e->getMessage()}\nSQL: {$query}", 1);
        }
    }

    /**
     * Get the ID of the last inserted row.
     */
    public function lastInsertId(): string
    {
        return $this->conn->lastInsertId();
    }
}