<?php

namespace  App\Components;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;


#[AsTwigComponent('all_users')]
class AllUsersComponent
{
    public int $id;
    public function __construct(
        private UserRepository $userRepository
    ) {

    }
    public function getAllUsers (): array
    {
        return $this->userRepository->findAll();
    }
}