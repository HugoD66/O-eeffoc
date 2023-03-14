<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Message\SmsNotification;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LikeController extends AbstractController
{
    /**
     * @Route("/O-eeffoc/like-post/{id}", name="app_like_post", methods={"POST"})
     */
    public function likePost(Post $post, EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $user = $this->getUser();
        if (!$user) {
            return new JsonResponse(['message' => 'You must be logged in to like a post'], Response::HTTP_UNAUTHORIZED);
        }
        $user = $user instanceof User ? $user : null;

        if ($user === null) {
            throw new \RuntimeException('The user object is null');
        }

        $post->addLikingUser($user);
        $entityManager->flush();

        return new JsonResponse(['message' => ''], Response::HTTP_OK);
    }

    /**
     * @Route("/O-eeffoc/unlike-post/{id}", name="app_unlike_post", methods={"POST"})
     */
    public function unlikePost(Post $post, EntityManagerInterface $entityManager): JsonResponse
    {
        $user = $this->getUser();
        if (!$user) {
            return new JsonResponse(['message' => 'You must be logged in to like a post'], Response::HTTP_UNAUTHORIZED);
        }
        $user = $user instanceof User ? $user : null;

        if ($user === null) {
            throw new \RuntimeException('The user object is null');
        }

        $post->removeLikingUser($user);
        $entityManager->flush();

        return new JsonResponse(['message' => ''], Response::HTTP_OK);
    }
}
