<?php

namespace App\Controller\Form;

use App\Entity\Message;
use App\Entity\User;
use App\Form\CompleteUserType;
use Detection\MobileDetect;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\String\Slugger\SluggerInterface;

class CompleteUserController extends AbstractController
{
    #[Route('/O-eeffoc/Complete-user/{id}', name: 'app_complete_user')]
    public function index(ManagerRegistry $doctrine,
                          AuthenticationUtils $authenticationUtils,
                          EntityManagerInterface $entityManager,
                          Request $request,
                          int $id,
                          SluggerInterface $slugger): Response
    {


        $detect = new MobileDetect($request->headers->all());
        if ($detect->isMobile()) {
            $isMobile = true;
        } else {
            // Code pour les ordinateurs de bureau
            $isMobile = false;
        }
        $userList = $doctrine->getRepository(User::class)->findAll();
        $messageNotif = $doctrine->getRepository(Message::class)->findAll();

        $user= $this->getUser();
        $form= $this->createForm(CompleteUserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $picture = $form->get('picture')->getData();
            if ($picture) {
                $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $picture->guessExtension();
                try {
                    $picture->move(
                        $this->getParameter('recipe-picture'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $user->setPicture($newFilename);
                $user =  $form->getData();

            }
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->render('actu/actu.html.twig', [
            'form'          => $form->createView(),
            'title'         => 'O-eeffoC Finir enregistrement',
            'isMobile'      => $isMobile,
            'user'          => $user,
            'userList'      => $userList,
            'messageNotif'       => $messageNotif,

        ]);
    }
}
