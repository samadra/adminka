<?php

class DBConnection extends PDO
{
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
        parent::__construct($dsn, $username, $password, $options);
    }
}