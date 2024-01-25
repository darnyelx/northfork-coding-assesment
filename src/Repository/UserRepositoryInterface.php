<?php
// src/Repository/UserRepository.php

namespace App\Repository;

use App\Entity\User;

interface UserRepositoryInterface
{
    public function findOneById($id): ?User;
    public function findAll();
    public function save(User $user): void;
    public function remove(User $user): void;
}
