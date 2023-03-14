<?php
namespace App\Components;

use App\Repository\UserRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('user_search')]
class UserSearchComponent
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $query = '';

    public function __construct(
        private UserRepository $userRepository
    ) {
    }

    public function getUsers(): array
    {
        return $this->userRepository->findByQuery($this->query);
    }
    public function getAllUsers (): array
    {
        return $this->userRepository->findAll();
    }
}