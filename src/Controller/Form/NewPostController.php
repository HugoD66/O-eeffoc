<?php

namespace App\Controller\Form;

use App\Entity\Message;
use App\Entity\Post;
use App\Form\NewPostType;
use Detection\MobileDetect;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Constraints\Date;

class NewPostController extends AbstractController
{
    #[Route('/O-eeffoc/Gestion-utilisateur/Nouveau-post/{id}', name: 'app_new_post')]
    public function index(ManagerRegistry $doctrine,
                          int $id,
                          Request $request,
                          EntityManagerInterface $entityManager,
                          SluggerInterface $slugger): Response
    {
        $detect = new MobileDetect($request->headers->all());
        if ($detect->isMobile()) {
            $isMobile = true;
        } else {
            // Code pour les ordinateurs de bureau
            $isMobile = false;
        }

        $user= $this->getUser();
        $messageNotif = $doctrine->getRepository(Message::class)->findAll();

        $post =new Post();
        $form= $this->createForm(NewPostType::class, $post);
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
                $post->setCreatedBy($this->getUser());
                $post->setCreatedAt(new \DateTimeImmutable());
                $post->setPicture($newFilename);
                $post =  $form->getData();

            }
            $entityManager->persist($post);
            $entityManager->flush();
        }

        return $this->render('actu/actu.html.twig', [
            'form'          => $form->createView(),
            'title'         => 'O-eeffoc Nouveau Post',
            'user'          => $user,
            'messageNotif'       => $messageNotif,

        ]);
    }
}
