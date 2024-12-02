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
    #[Route('/createNote/{id}', name: 'create_note')]
    public function createNote(int $id, EntityManagerInterface $entityManager, ValidatorInterface $validator, ): Response
    {
        $usersRepo = $entityManager->getRepository(Users::class);

        $user = $usersRepo->find($id);

        $note = new Notes();
        $note->setTitle("Lista de la compra");
        $note->setContent("Chuches, albondigas, una rtx 2060, una novia (que respire (opcional)), un poco de autoestima");
        $note->setArchived(false);
        $note->setCreationDate(new \DateTime());
        $note->setIdUser($user);

        
        // check for errors in the fields using validator (auto_mapping)
        $errors = $validator->validate($note);
        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        }

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($note);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new user with id '.$note->getId());
    }

    #[Route('/newNote', name: 'new_note')]
    public function newNote(Request $request, EntityManagerInterface $entityManager): Response
    {
        $note = new Notes();
        $note->setTitle("Nueva nota");
        $note->setContent("El contenido de la nota nueva");
        $note->setColor("#1F9BFD");

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

        return $this->render('notes/index.html.twig', ['form' => $form]);
    }

}