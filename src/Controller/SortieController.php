<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\SortieType;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController
{
    /**
     * @Route("/sortie/creation", name="sortie_creationDeSortie")
     */
    public function creationDeSortie(Request $request,EntityManagerInterface $entityManager): Response
    {
        $sortie= new Sortie();
        //Création du formulaire et du traitement
        $sortieForm=$this->createForm(SortieType::class, $sortie);
        //TODO traitement du formulaire à faire

        $sortieForm->handleRequest($request);
        if($sortieForm->isSubmitted()){


            $entityManager->persist($sortie);
            $entityManager->flush();

            $this->addFlash('succes','Félicitation, la sortie à bien été créée!');

            return $this->redirectToRoute('sortie_afficher',[
                'id'=>$sortie->getId()
            ]);
        }

        return $this->render("/sortie/creationDeSortie.html.twig", [
            'sortieForm'=>$sortieForm->createView()
        ]);
    }

    /**
     * @Route("/sortie/afficher/{id}",name="sortie_afficher")
     */
    public function afficher(int $id,SortieRepository $sortieRepository):Response
    {
        $sortie= $sortieRepository->find($id);
        return $this->render("/sortie/afficher.html.twig",['sortie'=>$sortie]);
    }

    /**
     * @Route("/sortie/modifier",name="sortie_modifier")
     */
    public function modifier():Response
    {
        return $this->render("/sortie/modifier.html.twig");
    }
}