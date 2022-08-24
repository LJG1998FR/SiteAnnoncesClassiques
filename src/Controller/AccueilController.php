<?php

namespace App\Controller;

use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

class AccueilController extends AbstractController
{
    #[Route('/accueil', name: 'app_accueil', methods: ['GET'])]
    public function index(AnnonceRepository $annonceRepository, PaginatorInterface $paginator, Request $request): Response
    {
        return $this->render('annonce/index.html.twig', [
            'annonces' => $paginator->paginate(
            $annonceRepository->findAll(),
            $request->query->getInt('page', 1),
            5
        )
        ]);
    }
}
