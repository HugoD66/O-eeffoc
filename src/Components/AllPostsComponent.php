<?php

namespace  App\Components;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;


#[AsTwigComponent('all_posts')]
class AllPostsComponent
{
    public int $id;
    public function __construct(
        private PostRepository $postRepository
    ) {

    }
    public function getAllPosts (): array
    {
        return $this->postRepository->findAll();
    }
}