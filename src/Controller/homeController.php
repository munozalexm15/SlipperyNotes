<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class homeController extends AbstractController
{
    #[Route('/')]
    public function number(): Response
    {

        return $this->render(
            'home.html.twig'
        );
    }
}