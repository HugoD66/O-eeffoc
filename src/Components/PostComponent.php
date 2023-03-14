<?php

namespace  App\Components;

use App\Entity\Post;
use App\Entity\User;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;


#[AsTwigComponent('post')]
class PostComponent
{
    public int $id;
    public function __construct(
        private PostRepository $postRepository
    ) {

    }
    public function getPost (): Post
    {
        return $this->postRepository->find($this->id);
    }
}