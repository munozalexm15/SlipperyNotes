<?php

namespace App\Controller;

use App\Entity\Categories;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CategoriesController extends AbstractController
{
    #[Route('/createCategory', name: 'create_category')]
    public function createCategory(EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        $category = new Categories();
        $category->setName("Compras");

        
        // check for errors in the fields using validator (auto_mapping)
        $errors = $validator->validate($category);
        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        }

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($category);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new user with id '.$category->getId());
    }
}