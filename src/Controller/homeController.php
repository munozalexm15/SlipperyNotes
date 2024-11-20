<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use App\Entity\Notes;
use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

class homeController extends AbstractController
{

    #[Route('/', name: 'homepage')]
    public function number(EntityManagerInterface $entityManager): Response
    {
        $userCount = $entityManager->getRepository(Users::class)->getUserCount();
        $notesCreated = $entityManager->getRepository(Notes::class)->getNotesCount();


        return $this->render(
            'home.html.twig', ['userCount' => $userCount, 'notesCreated' => $notesCreated]
        );
    }
}