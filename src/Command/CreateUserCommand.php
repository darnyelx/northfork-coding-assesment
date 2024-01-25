<?php
namespace App\Command;

class CreateUserCommand
{
    private $username;
    private $email;

    private $name;

    public function __construct(string $username, string $email, string $name)
    {
        $this->username = $username;
        $this->email = $email;
        $this->name = $name;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getName()
    {
        return $this->name;
    }

}
