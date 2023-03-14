<?php

namespace  App\Components;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;


#[AsTwigComponent('user')]
class UserComponent
{
    public int $id;
    public function __construct(
        private UserRepository $userRepository
    ) {

    }
    public function getUser (): User
    {
        return $this->userRepository->find($this->id);
    }
}