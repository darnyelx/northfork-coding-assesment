<?php

namespace App\tests;

use App\Command\CreateUserCommand;
use PHPUnit\Framework\TestCase;

class CreateUserCommandTest extends TestCase
{
    public function testCreateUserCommand()
    {
        $username = 'testuser';
        $email = 'test@example.com';
        $name = 'Test User';

        $command = new CreateUserCommand($username, $email, $name);

        $this->assertSame($username, $command->getUsername());
        $this->assertSame($email, $command->getEmail());
        $this->assertSame($name, $command->getName());
    }
}
