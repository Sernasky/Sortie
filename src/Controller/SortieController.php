<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController
{
    /**
     * @Route("/sortie/creation", name="sortie_creationDeSortie")
     */
    public function creationDeSortie(): Response
    {

        return $this->render("/sortie/creationDeSortie.html.twig");
    }

    /**
     * @Route("/sortie/afficher",name="sortie_afficher")
     */
    public function afficher():Response
    {
        return $this->render("/sortie/afficher.html.twig");
    }

    /**
     * @Route("/sortie/modifier",name="sortie_modifier")
     */
    public function modifier():Response
    {
        return $this->render("/sortie/modifier.html.twig");
    }
}