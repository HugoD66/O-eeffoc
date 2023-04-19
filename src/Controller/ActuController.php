<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

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



        //Recuperation infos
        $user = $this->getUser();

        $userList = $doctrine->getRepository(User::class)->findAll();
        $usersQuery = $doctrine->getRepository(User::class)->findAll();
        $messageNotif = $doctrine->getRepository(Message::class)->findAll();

        return $this->render('actu/actu.html.twig', [
            'title' => 'O-eeffoC Actu',
            'last_username' => $lastUsername,
            'error'         => $error,
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
