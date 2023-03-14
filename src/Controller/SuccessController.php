<?php

namespace App\Controller;

use App\Entity\Message;
use Detection\MobileDetect;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SuccessController extends AbstractController
{
    #[Route('/O-eeffoc/Changement-mdp/Success', name: 'app_success_change_password')]
    public function successChangePassword(Request $request,ManagerRegistry $doctrine): Response
    {

        $user= $this->getUser();
        $messageNotif = $doctrine->getRepository(Message::class)->findAll();

        $detect = new MobileDetect($request->headers->all());
        if ($detect->isMobile()) {
            $isMobile = true;
        } else {
            // Code pour les ordinateurs de bureau
            $isMobile = false;

        }
        return $this->render('actu/actu.html.twig', [
            'title' => 'O-eeffoC Succés Changement MDP',
            'user' => $user,
            'messageNotif' => $messageNotif,
        ]);
    }

}