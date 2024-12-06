<?php

namespace App\Controller;

use App\Entity\Notes;
use App\Entity\Users;
use App\Form\NoteFormType;
use Doctrine\DBAL\Types\TextType;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Config\Framework\RequestConfig;

class NotesController extends AbstractController
{
    #[Route('/newNote', name: 'new_note')]
    public function newNote(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()) {
            $this->redirectToRoute('homepage');
        }
        $user =  $entityManager -> getRepository(Users::class)->find($this->getUser()->getUserIdentifier());

        $note = new Notes();
        $note->setTitle("Nueva nota");
        $note->setContent("");
        $note->setColor("#1F9BFD");
        $note->setLastModified(new \DateTime());
        $note->setCreationDate(new \DateTime());
        $note->setReminderDate(new \DateTime());

        $note->setIdUser($this->getUser());
        $note->setArchived(false);

        $form = $this->createForm(NoteFormType::class, $note);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $newNote = $form->getData();
            // ... perform some action, such as saving the task to the database
            $entityManager->persist($note);
            $entityManager->flush();

            return $this->redirectToRoute('dashboard');
        }
        else if ($form->isSubmitted() && !$form->isValid()) {
            return new Response('No valido');
        }

        return $this->render('notes/index.html.twig', ['form' => $form, 'user' => $user]);
    }

    #[Route('/editNote/{id}', name: 'edit_note')]
    public function editNote(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()) {
            $this->redirectToRoute('homepage');
        }
        $user =  $entityManager -> getRepository(Users::class)->find($this->getUser()->getUserIdentifier());

        $note = $entityManager->getRepository(Notes::class)->find($id);

        $form = $this->createForm(NoteFormType::class, $note);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $note->setLastModified(new \DateTime());

            // ... perform some action, such as saving the task to the database
            $entityManager->persist($note);

            $entityManager->flush();


            return $this->redirectToRoute('dashboard');
        }
        else if ($form->isSubmitted() && !$form->isValid()) {
            return new Response('No valido');
        }

        return $this->render('notes/index.html.twig', ['form' => $form, 'user' => $user]);
    }



}