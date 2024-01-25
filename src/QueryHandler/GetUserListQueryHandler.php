<?php

namespace App\QueryHandler;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use App\Query\GetUserListQuery;


#[AsMessageHandler]
class GetUserListQueryHandler
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(GetUserListQuery $query):array
    {
        return $this->entityManager->getRepository(User::class)->findAll();
    }
}
