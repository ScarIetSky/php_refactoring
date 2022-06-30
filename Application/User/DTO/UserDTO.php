<?php

namespace project\Application\User\DTO;

use project\Application\User\Exception\AgeOutOfBoundaries;
use project\Application\User\Exception\NameIsTooShort;
use project\Application\User\Exception\SurnameIsTooShort;

final class UserDTO
{
    /**
     * Максимальный возраст пользователя.
     */
    private const MAX_AGE = 100;

    /**
     * Минимальный возраст пользователя.
     */
    private const MIN_AGE = 18;

    /**
     * Минимальная длина имени.
     */
    private const MIN_NAME_LENGTH = 3;

    /**
     * Минимальная длина фамилии.
     */
    private const MIN_SURNAME_LENGTH = 3;

    /**
     * @var string
     */
    private string $name;

    /**
     * @var string
     */
    private string $lastName;

    /**
     * @var int
     */
    private int $age;

    /**
     * @param string $name
     * @param string $lastName
     * @param int $age
     *
     * @throws AgeOutOfBoundaries
     * @throws NameIsTooShort
     * @throws SurnameIsTooShort
     */
    public function __construct(string $name, string $lastName, int $age)
    {
        if (strlen($name) < self::MIN_NAME_LENGTH) {
            throw new NameIsTooShort('name is too short');
        }

        $this->name = $name;

        if (strlen($lastName) < self::MIN_SURNAME_LENGTH) {
            throw new SurnameIsTooShort('surname is too short');
        }

        $this->lastName = $lastName;

        if ($age < self::MIN_AGE || $age > self::MAX_AGE) {
            throw new AgeOutOfBoundaries('Неверный возраст');
        }

        $this->age = $age;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }
}
