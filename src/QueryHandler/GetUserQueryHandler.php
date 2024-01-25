<?php

namespace App\QueryHandler;

use App\Entity\User;
use App\Query\GetUserQuery;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetUsersQueryHandler
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(GetUserQuery $query)
    {
        $userId = $query->getUserId();
        return $this->entityManager->getRepository(User::class)->find($userId);
    }
}
