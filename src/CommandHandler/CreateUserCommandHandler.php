<?php
// src/CommandHandler/CreateUserCommandHandler.php

namespace App\CommandHandler;

use App\Command\CreateUserCommand;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateUserCommandHandler
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(CreateUserCommand $command)
    {
        $user = new User();
        $user->setName($command->getName());
        $user->setEmail($command->getEmail());
        $user->setName($command->getName());

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
