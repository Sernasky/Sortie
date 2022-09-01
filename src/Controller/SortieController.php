<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Sortie;
use App\Form\SearchType;
use App\Form\SortieType;
use App\Repository\EtatRepository;
use App\Repository\LieuRepository;
use App\Repository\SortieRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class SortieController extends AbstractController
{
    /**
     * @Route("/sorties",name="sorties_list")
     */
    public function index(SortieRepository $sortieRepository, Request $request): Response
    {
        //on doit générer le formulaire pour pouvoir l'afficher
        //initialisation des données
        $data = new SearchData();
        $form = $this->createForm(SearchType::class, $data);
        $form->handleRequest($request);
        //on Récupère l'ensemble des produit lié à une recherche
        $sorties = $sortieRepository->findSearch($data);
        return $this->renderForm('sortie/list.html.twig', [
            'sorties' => $sorties,
            'form' => $form
        ]);

    }

    /**
     * @Route("/sortie/creation", name="sortie_creationDeSortie")
     */
    public function creationDeSortie(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository, EtatRepository $etatRepository, LieuRepository $lieuRepository): Response
    {

        $sortie = new Sortie();
        $etat = $etatRepository->find(16);
        $sortie->setEtat($etat);


        //Création du formulaire et du traitement
        $sortieForm = $this->createForm(SortieType::class, $sortie);
        //TODO traitement du formulaire à faire

        $sortieForm->handleRequest($request);
        if ($sortieForm->isSubmitted() && $sortieForm->isValid()) {

            $organisateur = $userRepository->find($this->getUser());
            $sortie->setUser($organisateur);

            //TODO configurer le lieu/ enlever le bouchonage
            $lieu = $lieuRepository->find(1);
            $sortie->setLieu($lieu);

            $etat = $etatRepository->find(17);
            $sortie->setEtat($etat);


            $entityManager->persist($sortie);
            $entityManager->flush();

            $this->addFlash('succes', 'Félicitations, la sortie à bien été créée!');

            return $this->redirectToRoute('sortie_afficher', [
                'id' => $sortie->getId()
            ]);
        }

        return $this->render("/sortie/creationDeSortie.html.twig", [
            'sortieForm' => $sortieForm->createView()
        ]);
    }

    /**
     * @Route("/sortie/afficher/{id}",name="sortie_afficher")
     */
    public function afficher(int $id, SortieRepository $sortieRepository, EtatRepository $etatRepository): Response
    {
        $sortie = $sortieRepository->find($id);
        $date_now = new \DateTime('now');
        $date_debut = $sortie->getDateHeureDebut();

        if ($date_now < $date_debut) {
            $participants = $sortieRepository->find($id)->getInscription();
            return $this->render("/sortie/afficher.html.twig", [
                'sortie' => $sortie,
                'participants' => $participants
            ]);
        } else {
            $etat = $etatRepository->find(22);
            $sortie->setEtat($etat);
            return $this->render("/sortie/archive.html.twig");
        }//
    }

    /**
     * @Route("/sortie/afficher/{id}/inscrire",name="sortie_inscription")
     */
    public function inscription(int $id, EtatRepository $etatRepository, SortieRepository $sortieRepository, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {

        $sortie = $sortieRepository->find($id);
        $participant = $userRepository->find($this->getUser());

        $dateNow = new \DateTime("now");
        $dateMax = $sortie->getDateLimiteInscription();

        if ($dateNow < $dateMax) {
            $sortie->addInscription($participant);
            $entityManager->persist($sortie);
            $entityManager->flush();

            $this->addFlash('succes', 'Félicitations, tu es inscrit!');
            return $this->render("/sortie/bravo.html.twig");
        } else {
            $sortie->setEtat($etatRepository->find(18));
            $entityManager->persist($sortie);
            $entityManager->flush();
            return $this->render('/sortie/cloture.html.twig');
        }
    }

    /**
     * @Route("/sortie/afficher/{id}/desinscrire",name="sortie_desinscription")
     */
    public function desinscription(int $id, SortieRepository $sortieRepository, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {

        $sortie = $sortieRepository->find($id);
        $participant = $userRepository->find($this->getUser());
        $sortie->removeInscription($participant);

        $entityManager->persist($sortie);
        $entityManager->flush();

        $this->addFlash('succes', 'Allez degage');
        return $this->render("/sortie/desinscriptionSortie.html.twig");
    }




//    /**
//     * @Route("/sortie/modifier",name="sortie_modifier")
//     */
//    public function modifier(Request $request, EntityManagerInterface $entityManager, User $user): Response
//    {
//        if ($this->getUser() !== $user) {
//            return $this->redirectToRoute('app_register');
//        }
//
//        $form = $this->createForm(UserType::class, $user);
//
//        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isValid()) {
//            $user = $form->getData();
//            $entityManager->persist($user);
//            $entityManager->flush();
//
//            $this->addFlash(
//                'success',
//                'les informations de votre compte ont bien été modifiées'
//            );
//            return $this->redirectToRoute('sorties_list');
//        }
//
//
//        return $this->render('user/updateProfil.html.twig', [
//            'form' => $form->createView()
//        ]);
//
//        return $this->render("/sortie/modifier.html.twig");
//    }
}