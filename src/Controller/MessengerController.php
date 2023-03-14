<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\MessagesType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessengerController extends AbstractController
{
    #[Route('/O-eeffoc/Messagerie-utilisateur/{id}', name: 'app_messenger')]
    public function index(ManagerRegistry $doctrine,
                          int $id): Response
    {
        $userId = $doctrine->getRepository(User::class)->find($id);
        $user = $doctrine->getRepository(User::class)->find($id);
        $userList = $doctrine->getRepository(User::class)->findAll();
        $messageNotif = $doctrine->getRepository(Message::class)->findAll();

        return $this->render('actu/actu.html.twig', [
            'title' => 'O-eeffoc Messagerie',
            'user' => $user,
            'userId' => $userId,
            'userList' => $userList,
            'messageNotif'       => $messageNotif,

        ]);
    }
    #[Route('/O-eeffoc/Messagerie-utilisateur/envoyer/{id}', name: 'send')]
    public function send(ManagerRegistry $doctrine,
                         int $id,
                         Request $request,
                         EntityManagerInterface $entityManager): Response
    {
        $user = $doctrine->getRepository(User::class)->find($id);
        $messageNotif = $doctrine->getRepository(Message::class)->findAll();

        $message = new Message();
        $form = $this->createForm(MessagesType::class, $message);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $message->setSender($this->getUser());
            $entityManager->persist($message);
            $entityManager->flush();

            $this->addFlash("success", "Envoyé.");
            return $this->redirectToRoute('app_messenger', ['id' => $id]);
        }
        return $this->render('actu/actu.html.twig', [
            'form'          => $form->createView(),
            'title'         => 'O-eeffoc Envoi de message',
            'user'          => $user,
            'messageNotif'       => $messageNotif,

        ]);
    }
    #[Route('/O-eeffoc/Messagerie-utilisateur/recus/{id}', name: 'received')]
    public function received(ManagerRegistry $doctrine,
                            int $id): Response
    {
        $user = $doctrine->getRepository(User::class)->find($id);
        $messageNotif = $doctrine->getRepository(Message::class)->findAll();

        return $this->render('actu/actu.html.twig', [
            'title'         => 'O-eeffoc Messages reçus',
            'user'          => $user,
            'messageNotif'       => $messageNotif,

        ]);
    }
    #[Route('/O-eeffoc/Messagerie-utilisateur/recus/{user_id}/{message_id}', name: 'readone')]
    public function read(ManagerRegistry $doctrine, int $user_id, int $message_id,  EntityManagerInterface $entityManager): Response
    {
        $user = $doctrine->getRepository(User::class)->find($user_id);
        $message_id = $doctrine->getRepository(Message::class)->find($message_id);
        $messageNotif = $doctrine->getRepository(Message::class)->findAll();

        $message_id->setIsRead(true);
        $entityManager->persist($message_id);
        $entityManager->flush();
        return $this->render('actu/actu.html.twig', [
            'title'         => 'O-eeffoc Messages reçus',
            'user'          => $user,
            'message'       => $message_id,
            'messageNotif' => $messageNotif,
        ]);
    }
    #[Route('/O-eeffoc/Messagerie-utilisateur/envoyes/{id}', name: 'sent')]
    public function envoyes(ManagerRegistry $doctrine, int $id): Response
    {
        $user = $doctrine->getRepository(User::class)->find($id);
        $messages = $doctrine->getRepository(Message::class)->findAll();
        $messageNotif = $doctrine->getRepository(Message::class)->findAll();

        return $this->render('actu/actu.html.twig', [
            'title'         => 'O-eeffoc Messages enoyés',
            'user'          => $user,
            'messages'      => $messages,
            'messageNotif' => $messageNotif,

        ]);
    }
}
