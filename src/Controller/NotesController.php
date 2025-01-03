<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Notes;
use App\Entity\Users;
use App\Form\NoteFormType;
use Doctrine\DBAL\Types\TextType;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Config\Framework\RequestConfig;
use function Webmozart\Assert\Tests\StaticAnalysis\length;

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

        return $this->render('notes/index.html.twig', ['form' => $form, 'user' => $user, 'section' => null]);
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

        return $this->render('notes/index.html.twig', ['form' => $form, 'user' => $user, 'section' => null]);
    }

    #[Route('/archiveNotes', name: 'archive_notes')]
    public function archiveNotes(Request $request, EntityManagerInterface $entityManager): Response
    {
        $params = json_decode($request->getContent(), true);
        foreach ($params["selectedNotes"] as $noteId) {
            $note = $entityManager->getRepository(Notes::class)->find($noteId);
            $userID = $entityManager->getRepository(Users::class)->find($this->getUser()->getUserIdentifier());
            if ($note->getIdUser() == $userID) {
               $note->setArchived(true);
               $entityManager->persist($note);
               $entityManager->flush();
           }
        }
        return new Response('success');
    }

    #[Route('/unarchiveNotes', name: 'unarchive_notes')]
    public function unarchiveNotes(Request $request, EntityManagerInterface $entityManager): Response
    {
        $params = json_decode($request->getContent(), true);
        foreach ($params["selectedNotes"] as $noteId) {
            $note = $entityManager->getRepository(Notes::class)->find($noteId);
            $userID = $entityManager->getRepository(Users::class)->find($this->getUser()->getUserIdentifier());
            if ($note->getIdUser() == $userID) {
                $note->setArchived(false);
                $entityManager->persist($note);
                $entityManager->flush();
            }
        }
        return new Response('success');
    }

    #[Route('/TagNotes', name: 'tag_notes')]
    public function tagNotes(Request $request, EntityManagerInterface $entityManager): Response
    {
        $params = json_decode($request->getContent(), true);

        $tag = $entityManager->getRepository(Categories::class)->findOneBy(array('name' =>(strtolower($params['selectedTag'])) ));
        if ($tag == null) {
            $tag = new Categories();

            $tag->setName(str_replace(' ', '', strtolower($params['selectedTag'])));
            $entityManager->persist($tag);
            $entityManager->flush();
        }

        $tag = $entityManager->getRepository(Categories::class)->findOneBy(array('name' =>(strtolower($params['selectedTag'])) ));
        foreach ($params["selectedNotes"] as $noteId) {

            $note = $entityManager->getRepository(Notes::class)->find($noteId);
            if ($note == null) {
                return new Response('error');
            }
            $userID = $entityManager->getRepository(Users::class)->find($this->getUser()->getUserIdentifier());
            if ($note->getIdUser() == $userID) {
                $note->addIdCategory($tag);
                $entityManager->persist($note);
                $entityManager->flush();
            }
        }

        return new Response('success');
    }

    #[Route('/removeTagFromNote/{noteId}&{tagId}', name: 'remove_tag_note')]
    public function removeTagFromNote(int $noteId, int $tagId, Request $request, EntityManagerInterface $entityManager): Response
    {

        $tag = $entityManager->getRepository(Categories::class)->find($tagId);
        $note = $entityManager->getRepository(Notes::class)->find($noteId);
        if ($tag == null || $note == null) {
            return new Response('error');
        }

        $note->removeIdCategory($tag);

        $entityManager->persist($note);
        $entityManager->flush();

        if ($tag->getIdNote()->count() == 0) {
            $entityManager->remove($tag);
            $entityManager->flush();
        }

        return $this->redirectToRoute('dashboard');
    }

    #[Route('/deleteNotes', name: 'delete_notes')]
    public function deleteNotes(Request $request, EntityManagerInterface $entityManager): Response
    {
        $params = json_decode($request->getContent(), true);
        foreach ($params["selectedNotes"] as $noteId) {
            $note = $entityManager->getRepository(Notes::class)->find($noteId);
            $userID = $entityManager->getRepository(Users::class)->find($this->getUser()->getUserIdentifier());
            if ($note->getIdUser() == $userID) {
                $entityManager->remove($note);
                $entityManager->flush();
            }
        }
        return new Response('success');
    }
}