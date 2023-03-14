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
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\JsonResponse;

class ActuController extends AbstractController
{
    #[Route('/O-eeffoc/Actu', name: 'app_actu')]
    public function index(ManagerRegistry $doctrine,
                          AuthenticationUtils $authenticationUtils,
                          Request $request): Response
    {
        //Login
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        //Format Ecran
        $detect = new MobileDetect($request->headers->all());
        if ($detect->isMobile()) {
            $isMobile = true;
        } else {
            // Code pour les ordinateurs de bureau
            $isMobile = false;
        }

        //Recuperation infos
        $user = $this->getUser();

        $userList = $doctrine->getRepository(User::class)->findAll();
        $usersQuery = $doctrine->getRepository(User::class)->findAll();
        $messageNotif = $doctrine->getRepository(Message::class)->findAll();

        return $this->render('actu/actu.html.twig', [
            'title' => 'O-eeffoC Actu',
            'last_username' => $lastUsername,
            'error'         => $error,
            'isMobile'      => $isMobile,
            'user'          => $user,
            'userList'      => $userList,
            'usersQuery'    =>$usersQuery,
            'messageNotif'       => $messageNotif,
        ]);
    }




    #[Route('/logout', name: 'app_logout', methods: ['GET'])]
    public function logout()
    {
    }
}
