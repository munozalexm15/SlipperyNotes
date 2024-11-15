<?php

namespace App\Controller;

use App\Entity\Notes;
use App\Entity\Users;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class NotesController extends AbstractController
{
    #[Route('/createNote/{id}', name: 'create_note')]
    public function createNote(int $id, EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
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
}