<?php

namespace App\Controller;

use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class UserController extends AbstractController
{

    #[Route('/registerUser', name: 'create_user')]
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


}