<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FollowController extends AbstractController
{
    #[Route('/O-eeffoc/follow-user/{id}', name: 'app_follow', methods: 'POST')]
    public function followUser(User $user, EntityManagerInterface $entityManager): JsonResponse
    {
        $currentUser = $this->getUser();
        if (!$currentUser) {
            return new JsonResponse(['message' => 'You must be logged in to follow a user'], Response::HTTP_UNAUTHORIZED);
        }

        $user->addFollowingUser($currentUser);
        $entityManager->flush();

        return new JsonResponse(['message' => 'User Followed'], Response::HTTP_OK);
    }


    #[Route('/O-eeffoc/unfollow-user/{id}', name: 'app_unfollow', methods: 'POST')]
    public function unfollowUser(User $user, EntityManagerInterface $entityManager): JsonResponse
    {
        $currentUser = $this->getUser();
        if (!$currentUser) {
            return new JsonResponse(['message' => 'You must be logged in to follow a user'], Response::HTTP_UNAUTHORIZED);
        }

        $user->removeFollowingUser($currentUser);
        $entityManager->flush();

        return new JsonResponse(['message' => 'User unFollowed'], Response::HTTP_OK);

    }
}
