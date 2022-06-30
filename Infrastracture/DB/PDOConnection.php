<?php

namespace project\Infrastracture\DB;

use PDO;

class PDOConnection
{
    /**
     * @var PDO
     */
    private PDO $connection;

    /**
     * @param string $dsn
     * @param string $user
     * @param string $password
     *
     * @throws \PDOException
     */
    public function __construct(string $dsn, string $user, string $password)
    {
        $this->connection = new PDO($dsn, $user, $password);
    }

    /**
     * @return PDO
     */
    public function getConnection(): PDO
    {
        return $this->connection;
    }
}
