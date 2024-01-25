<?php

namespace App\CommandHandler;

use App\Command\DeleteUserCommand;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use App\Entity\User;

#[AsMessageHandler]

class DeleteUserCommandHandler 
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(DeleteUserCommand $command)
    {
        $user = $this->entityManager->getRepository(User::class)->find($command->getUserId());

        if ($user) {
            $this->entityManager->remove($user);
            $this->entityManager->flush();
        }
    }
}
