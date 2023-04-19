<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Post;
use App\Entity\User;
use Detection\MobileDetect;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GestionController extends AbstractController
{
    #[Route('/O-eeffoc/Gestion-utilisateur/{id}', name: 'app_gestion')]
    public function index(ManagerRegistry $doctrine,
                          int $id,
                          Request $request): Response
    {

        $user = $doctrine->getRepository(User::class)->find($id);
        $userList = $doctrine->getRepository(User::class)->findAll();
        $userPost =  $doctrine->getRepository(Post::class)->findBy(['createdBy' => $user]);
        $post = $doctrine->getRepository(Post::class)->findAll();

        $messageNotif = $doctrine->getRepository(Message::class)->findAll();

        $followings = $doctrine->getRepository(User::class)->findFollowers($id);
        $followers = $doctrine->getRepository(User::class)->findFollowings($id);

        return $this->render('actu/actu.html.twig', [
            'user' => $user,
            'title' => 'O-eeffoc Gestion Compte',
            'userList' => $userList,
            'post' =>  $post,
            'userPost' => $userPost,
            'followings' => $followings,
            'followers' => $followers,
            'messageNotif'       => $messageNotif,

        ]);
    }
}
