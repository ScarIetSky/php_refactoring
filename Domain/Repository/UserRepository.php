<?php

namespace project\Domain\Repository;

use project\Application\User\DTO\UserDTO;
use project\Domain\Entity\User\User;

interface UserRepository
{
    /**
     * Возвращает пользователей старше заданного возраста.
     *
     * @param int $age
     * @param int $limit
     *
     * @return array<User>
     */
    public function getUsersOlderThan(int $age, int $limit): array;

    /**
     * Возвращает пользователей по списку имен.
     *
     * @param array $names
     *
     * @return array<User>
     */
    public function getByNames(array $names): array;

    /**
     * Добавляет пользователей в базу данных.
     *
     * @param array<UserDTO> $users
     *
     * @return array<string>
     */
    public function addUsers(array $users): array;
}
