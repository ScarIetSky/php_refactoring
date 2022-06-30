<?php

namespace project\Domain\Entity\User;

class User
{
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
     */
    public function __construct(string $name, string $lastName, int $age)
    {
        $this->name = $name;
        $this->lastName = $lastName;
        $this->age = $age;
    }
}
