<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Form\AnnonceType;
use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/annonce')]
class AnnonceController extends AbstractController
{
    #[Route('/new', name: 'app_annonce_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AnnonceRepository $annonceRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $annonce = new Annonce();
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $annonce->setTelephone($this->getUser());
            $annonceRepository->add($annonce, true);

            $this->addFlash(
                'newannonce',
                'Annonce ajoutée avec succès!'
            );

            return $this->redirectToRoute('app_accueil', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('annonce/new.html.twig', [
            'annonce' => $annonce,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_annonce_show', methods: ['GET'])]
    public function show(Annonce $annonce): Response
    {
        return $this->render('annonce/show.html.twig', [
            'annonce' => $annonce,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_annonce_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Annonce $annonce, AnnonceRepository $annonceRepository): Response
    {
        if ( $annonce->getTelephone() != $this->getUser() ) {
            return $this->redirectToRoute('app_accueil');
        }

        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $annonceRepository->add($annonce, true);

            $this->addFlash(
                'editannonce',
                'Annonce modifiée avec succès!'
            );

            return $this->redirectToRoute('app_accueil', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('annonce/edit.html.twig', [
            'annonce' => $annonce,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_annonce_delete', methods: ['POST'])]
    public function delete(Request $request, Annonce $annonce, AnnonceRepository $annonceRepository): Response
    {
        if ( $annonce->getTelephone() != $this->getUser() ) {
            return $this->redirectToRoute('app_accueil');
        }
        if ($this->isCsrfTokenValid('delete'.$annonce->getId(), $request->request->get('_token'))) {
            $annonceRepository->remove($annonce, true);
            $this->addFlash(
                'deleteannonce',
                'Annonce supprimée avec succès!'
            );
        }

        return $this->redirectToRoute('app_accueil', [], Response::HTTP_SEE_OTHER);
    }
}
