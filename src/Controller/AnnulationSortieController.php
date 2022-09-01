<?php

namespace App\Controller;

use App\Form\AnnulationType;
use App\Repository\EtatRepository;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnulationSortieController extends AbstractController
{
    /**
     * @Route("/annulation/sortie/{id}", name="annulation_sortie")
     */
    public function annulation(int            $id, SortieRepository $sortieRepository, EntityManagerInterface $entityManager, Request $request,
                               EtatRepository $etatRepository): Response
    {
        $aujourdhui = new \DateTime('now');
        //Récupere la sortie à annuler
        $sortieSelected = $sortieRepository->find($id);

        //Crée le formulaire de Motif d'annulation
        $annulationForm = $this->createForm(AnnulationType::class, $sortieSelected);
        $annulationForm->handleRequest($request);

        if ($annulationForm->isSubmitted() && $annulationForm->isValid()) {
            //Modifie l'état de la sortie
            $sortieSelected->setEtat($etatRepository->find(21));
            $entityManager->flush();

            $this->addFlash('succes', 'Sortie annulée');
            //todo ajouter une page de redirection à la validation du formulaire

            return $this->redirectToRoute('sorties_list');
        }
        return $this->render('annulation_sortie/annulation.html.twig', ["sortie" => $sortieSelected, "annulationForm" => $annulationForm->createView()]);
    }
}
