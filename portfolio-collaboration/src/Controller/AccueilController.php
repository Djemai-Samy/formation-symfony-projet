<?php

namespace App\Controller;

use App\Repository\CollectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil_page')]
    public function index(CollectionRepository $collectionRepository): Response
    {
        $derniereCollections = $collectionRepository->findBy(["isPublic" => true], [], 10, 0);
        return $this->render('pages/index.html.twig', ['collections' => $derniereCollections]);
    }
}
