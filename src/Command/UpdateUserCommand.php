<?php
namespace App\Command;

class UpdateUserCommand
{
    private $userId;
    private $username;

    public function __construct(int $userId, string $username)
    {
        $this->userId = $userId;
        $this->username = $username;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getUsername(): string
    {
        return $this->username;
    }
}
