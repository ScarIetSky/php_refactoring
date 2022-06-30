<?php

namespace project\Domain\Factory;

use project\Domain\Entity\User\User;
use project\Domain\Exception\DataNotValid;

class UserFactory
{
    public function createUser(array $data): User
    {
        if (!isset($data['name'], $data['surname'], $data['age'])) {
            // более подробные проверки нужно добавить.
            throw new DataNotValid('Wrong data');
        }
        return new User(
            $data['name'],
            $data['surname'],
            $data['age'],
        );
    }
}
