<?php

namespace project\Infrastracture\Repository;

use PDO;
use project\Application\User\DTO\UserDTO;
use project\Domain\Entity\User\User;
use project\Domain\Exception\LogicRepositoryException;
use project\Domain\Factory\UserFactory;
use project\Domain\Repository\UserRepository;
use project\Infrastracture\DB\PDOConnection;

class PDOUserRepository implements UserRepository
{
    /**
     * @var PDOConnection
     */
    private PDOConnection $pdoConnection;

    /**
     * @var UserFactory
     */
    private UserFactory $userFactory;

    /**
     * @param PDOConnection $PDOConnection
     */
    public function __construct(PDOConnection $PDOConnection, UserFactory $userFactory)
    {
        $this->pdoConnection = $PDOConnection;
        $this->userFactory = $userFactory;
    }

    /**
     * Возвращает пользователей старше заданного возраста.
     *
     * @param int $age
     * @param int $limit
     *
     * @return array<User>
     */
    public function getUsersOlderThan(int $age, int $limit): array
    {
        $users = [];

        $stmt = $this->pdoConnection
            ->getConnection()
            ->prepare("SELECT id, name, lastName, from, age, settings FROM Users WHERE age > :age LIMIT :limit");
        $stmt->execute([
            ':age' => $age,
            ':limit' => $limit,
        ]);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($rows === null) {
            return $users;
        }

        foreach ($rows as $row) {
            $users[] = $this->userFactory->createUser($row);
        }

        return $users;
    }

    /**
     * Возвращает пользователей по списку имен.
     *
     * @param array $names
     *
     * @return array<User>
     */
    public function getByNames(array $names): array
    {
        $users = [];

        $stmt = $this->pdoConnection
            ->getConnection()
            ->prepare("SELECT id, name, lastName, from, age, settings FROM Users WHERE in (:names)");

        $stmt->execute([
            ':names' => implode(',', $names)
        ]);

        $rows = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($rows === null) {
            return $users;
        }

        foreach ($rows as $row) {
            $users[] = $this->userFactory->createUser($row);
        }

        return $users;
    }

    /**
     * Добавляет пользователей в базу данных.
     *
     * @param array<UserDTO> $users
     *
     * @return array<string>
     */
    public function addUsers(array $users): array
    {
        $ids = [];
        $stmt = $this->pdoConnection->getConnection()->prepare("INSERT INTO users (name, surname, age) VALUES (?,?,?)");

        try {
            $this->pdoConnection->getConnection()->beginTransaction();

            foreach ($users as $user)
            {
                $stmt->execute([$user->getName(), $user->getLastName(), $user->getAge()]);
            }

            $ids[] = (string) $this->pdoConnection->getConnection()->lastInsertId();

            $this->pdoConnection->getConnection()->commit();
        } catch (\PDOException $e) {
            $this->pdoConnection->getConnection()->rollBack();

            throw new LogicRepositoryException($e->getMessage());
        }

        return $ids;
    }
}
