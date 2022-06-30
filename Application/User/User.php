<?php

namespace project\Application\User;

use project\Application\User\DTO\UserDTO;
use project\Domain\Repository\UserRepository;

class User
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @param UserRepository $userRepository
     * @param int $limit
     */
    public function __construct(UserRepository $userRepository, int $limit)
    {
        $this->userRepository = $userRepository;
        $this->limit = $limit;
    }

    /**
     * Возвращает пользователей старше заданного возраста.
     * @param int $age
     *
     * @return array
     */
    public function getUsersOlderThan(int $age): array
    {
        return $this->userRepository->getUsersOlderThan($age, $this->limit);
    }

    /**
     * Возвращает пользователей по списку имен.
     *
     * @return array
     */
    public function getByNames(array $names): array
    {
        return $this->userRepository->getByNames($names);
    }

    /**
     * Добавляет пользователей в базу данных.
     *
     * @param array $usersData
     *
     * @return int
     */
    public function addUser(array $usersData): int
    {
        $users = [];

        foreach ($usersData as $userData) {
            $users[] = new UserDTO(
                $userData['name'] ?? '',
                $userData['surname'] ?? '',
                $userData['age'] ?? 0,
            );
        }

        return $this->userRepository->addUsers($users);
    }
}
