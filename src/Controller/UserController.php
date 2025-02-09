<?php

namespace App\Controller;

use App\Entity\Notes;
use App\Entity\Users;
use App\Form\SearchFormType;
use Doctrine\ORM\Query\ResultSetMapping;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class UserController extends AbstractController
{

    #[Route('/oldRegisterUser', name: 'oldcreate_user')]
    public function createUser(ValidatorInterface $validator, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new Users();
        $user->setName("Lxndrw");
        $user->setSurnames("Munoz Marine");
        $user->setAge(22);
        $user->setEmail("popolo90A@gmail.com");
        $user->setUsername("BlueHalp");

        //hash password (encrypt it for less security breaches)
        $plainPassword = 'superheroe1A';

        $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
        $user->setPassword($hashedPassword);

       
        
        // check for errors in the fields using validator (auto_mapping)
        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        }

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($user);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
        return new Response('Saved new user with id '.$user->getId());
    }


    #[Route('/deleteUser/', name: 'delete_user')]
    public function deleteUser(UserPasswordHasherInterface $passwordHasher, PasswordAuthenticatedUserInterface $user): void
    {
        $password = 'xXLocuroncioXx1';

        if (!$passwordHasher->isPasswordValid($user, $password)) {
            throw new AccessDeniedHttpException();
        }
    }

    #[Route('/dashboard', name: 'dashboard')]
    public function dashboard(EntityManagerInterface $entityManager, PaginatorInterface $paginator, Request $request) : Response
    {
        if (!$this->getUser()) {
            $this->redirectToRoute('homepage');
        }

        $userID = null;
        if ($this->getUser()) {
            $userID = $this->getUser()->getUserIdentifier();
        }
        $user =  $entityManager -> getRepository(Users::class)->find($userID);

        $query = $entityManager ->createQuery(
            'SELECT n from App\Entity\Notes n
            WHERE n.idUser = :user AND n.isArchived = false
            ORDER BY n.id'
        )->setParameter('user', $user);
        # $notes = $query -> getResult();
        $pagination = $paginator -> paginate(
            $query,
            $request->query->getInt('page', 1), 8
        );

        //Form for search bar
        $form = $this->createForm(SearchFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated

            $textSearch = $form->getData();
            $text = $textSearch['searchText'];

            return $this->redirectToRoute('search', ['searchText' => $text]);
        }


        return $this->render(
            '/user/index.html.twig', ['user' => $user, 'pagination' => $pagination, 'section' => 'dashboard', 'form' => $form]);
    }

    #[Route('/search/{searchText}', name: 'search')]
    public function searchNotes(string $searchText, EntityManagerInterface $entityManager, PaginatorInterface $paginator, Request $request) : Response
    {
        if (!$this->getUser()) {
            $this->redirectToRoute('homepage');
        }

        $userID = null;
        if ($this->getUser()) {
            $userID = $this->getUser()->getUserIdentifier();
        }
        $user =  $entityManager -> getRepository(Users::class)->find($userID);

        $query = $entityManager->createQuery(
            'SELECT n from App\Entity\Notes n
            WHERE n.idUser = :user AND (n.content LIKE :searchText OR n.title LIKE :searchText)'
        )->setParameters(['user' => $user, 'searchText' => '%'.$searchText.'%']);

        # $notes = $query -> getResult();
        $pagination = $paginator -> paginate(
            $query,
            $request->query->getInt('page', 1), 8
        );

        //Form for search bar
        $form = $this->createForm(SearchFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated

            $textSearch = $form->getData();
            $text = $textSearch['searchText'];

            return $this->redirectToRoute('search', ['searchText' => $text]);
        }

        return $this->render(
            '/user/index.html.twig', ['user' => $user, 'pagination' => $pagination, 'section' => 'dashboard', 'form' => $form]);
    }

    #[Route('/archived', name: 'archived')]
    public function archived(EntityManagerInterface $entityManager, PaginatorInterface $paginator, Request $request) : Response
    {
        if (!$this->getUser()) {
            $this->redirectToRoute('homepage');
        }

        $userID = null;
        if ($this->getUser()) {
            $userID = $this->getUser()->getUserIdentifier();
        }
        $user =  $entityManager -> getRepository(Users::class)->find($userID);
        $query = $entityManager ->createQuery(
            'SELECT n from App\Entity\Notes n
            WHERE n.idUser = :user AND n.isArchived = true
            ORDER BY n.id'
        )->setParameter('user', $user);

        # $notes = $query -> getResult();
        $pagination = $paginator -> paginate(
            $query,
            $request->query->getInt('page', 1), 8
        );

        $form = $this->createForm(SearchFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated

            $textSearch = $form->getData();
            $text = $textSearch['searchText'];

            return $this->redirectToRoute('search', ['searchText' => $text]);
        }

        return $this->render(
            '/user/archived.html.twig', ['user' => $user, 'pagination' => $pagination, 'section' => 'archived', 'form' => $form]);
    }

    #[Route('/reminders', name: 'reminders')]
    public function reminders(EntityManagerInterface $entityManager, PaginatorInterface $paginator, Request $request) : Response
    {
        if (!$this->getUser()) {
            $this->redirectToRoute('homepage');
        }

        $userID = null;
        if ($this->getUser()) {
            $userID = $this->getUser()->getUserIdentifier();
        }
        $user =  $entityManager -> getRepository(Users::class)->find($userID);
        $query = $entityManager ->createQuery(
            'SELECT n from App\Entity\Notes n
            WHERE n.idUser = :user AND n.reminderDate is not null
            ORDER BY n.reminderDate DESC'
        )->setParameter('user', $user);

        # $notes = $query -> getResult();
        $pagination = $paginator -> paginate(
            $query,
            $request->query->getInt('page', 1), 8
        );

        $form = $this->createForm(SearchFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated

            $textSearch = $form->getData();
            $text = $textSearch['searchText'];

            return $this->redirectToRoute('search', ['searchText' => $text]);
        }

        return $this->render(
            '/user/reminders.html.twig', ['user' => $user, 'pagination' => $pagination, 'section' => 'reminders', 'form' => $form]);
    }
}