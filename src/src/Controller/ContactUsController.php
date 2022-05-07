<?php

namespace App\Controller;

use App\Entity\UserMessage;
use App\Form\Type\UserMessageType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactUsController extends AbstractController
{

    #[Route("/contact_us", name: "contact_us")]
    public function new(Request $request,ManagerRegistry $doctrine): Response
    {
        $userMessage = new UserMessage();
//        $userMessage->setName("Parsa");
//        $userMessage->setEmailAddress("parsa.mastoory@gmail.com");
//        $userMessage->setSubject("Test");
//        $userMessage->setMessage("♥");

        $form = $this->createForm(UserMessageType::class, $userMessage);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $userMessage = $form->getData();

            // ... perform some action, such as saving the task to the database
            $entityManager = $doctrine->getManager();
            $entityManager->persist($userMessage);
            $entityManager->flush();

            return $this->redirectToRoute('message_saved');
        }

        return $this->renderForm('contact_us/new.userMessage.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route("/contact_us/message_saved_success", name: "message_saved")]
    public function success(): Response
    {
        return new Response("Message saved successfully");
    }

    #[Route("/contact_us/show_all", name: "show_all")]
    public function showAllMessages(): Response
    {
        return new Response("show_all");
    }

    #[Route("/contact_us/show_message/{id}", name: "show_message_by_id")]
    public function showMessage(ManagerRegistry $doctrine, int $id): Response
    {
        return new Response("show_by_id");
    }
}