<?php

namespace App\Controller\Form;

use App\Entity\Message;
use App\Form\ChangePasswordType;
use Detection\MobileDetect;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ChangePasswordController extends AbstractController
{
    #[Route('/O-eeffoc/Changement-mdp/{id}', name: 'app_change_password')]
    public function index(ManagerRegistry $doctrine,
                          Request $request,
                          UserPasswordHasherInterface $userPasswordHasher,
                          EntityManagerInterface $entityManager): Response
    {

        $user= $this->getUser();
        $messageNotif = $doctrine->getRepository(Message::class)->findAll();

        $form = $this->createForm(ChangePasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('app_success_change_password');
        }
            return $this->render('actu/actu.html.twig', [
            'title' => 'O-eeffoc Changement MDP',
            'user'  => $user,
            'form' => $form->createView(),
            'messageNotif'       => $messageNotif,

            ]);
    }
}
