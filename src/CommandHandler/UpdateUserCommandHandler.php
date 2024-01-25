<?php
namespace App\CommandHandler;

use App\Command\UpdateUserCommand;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use App\Entity\User;

#[AsMessageHandler]
class UpdateUserCommandHandler
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(UpdateUserCommand $command)
    {
        $user = $this->entityManager->getRepository(User::class)->find($command->getUserId());

        if ($user) {
            $user->setUsername($command->getUsername());
            $this->entityManager->flush();
        }
    }
}
