<?php

namespace App\Controller;

use App\Entity\Photos;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PhotosController extends AbstractController
{
    #[Route('/AddPhoto', name: 'add_photo')]
    public function createPhoto(EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        $photo = new Photos();
        $photo->setName("fotito");
        $photo->setResourcePath("/jeje/jaja");

        
        // check for errors in the fields using validator (auto_mapping)
        $errors = $validator->validate($photo);
        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        }

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($photo);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new user with id '.$photo->getId());
    }
}