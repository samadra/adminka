<?php


class DB
{
    private ?PDO $db = null;
    private string $dsn = 'mysql:dbname=adminka;host=localhost';
    private string $username = 'root';
    private string $password = '';
    private array $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];

    public function __construct()
    {
        $dsn = $this->dsn;
        $username = $this->username;
        $password = $this->password;
        $options = $this->options;
        try {
            $this->db = new PDO($dsn, $username, $password, $options);
        } catch (PDOException $PDOException) {
            throw new PDOException($PDOException->getMessage());
        }
    }

    /**
     * @throws PDOException
     */
    public function select($statement = "", $parameters = []): array
    {
        try {
            $stmt = $this->executeStatement($statement, $parameters);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }

    private function executeStatement($statement = "", $parameters = []): bool|PDOStatement
    {
        try {
            $stmt = $this->db->prepare($statement);
            $stmt->execute($parameters);
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }

    public function first($statement = "", $parameters = []): array
    {
        try {
            $stmt = $this->executeStatement($statement, $parameters);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }

    /**
     * @throws PDOException
     */
    public function insert($statement = "", $parameters = []): string
    {
        try {
            $this->executeStatement($statement, $parameters);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }

    /**
     * @throws PDOException
     */
    public function update($statement = "", $parameters = [])
    {
        try {
            $this->executeStatement($statement, $parameters);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }
}