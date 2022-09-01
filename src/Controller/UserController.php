<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user/{id}', name: 'user')]
    public function updateProfil(User $user, Request $request, EntityManagerInterface $manager): Response
    {
        //test pour savoir si il y a un utilisateur connecté, sinon redirection vers la page d'identification
        if ($this->getUser() !== $user) {
            return $this->redirectToRoute('app_register');
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        //test verification du formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'les informations de votre compte ont bien été modifiées'
            );
            return $this->redirectToRoute('sorties_list');
        }
        return $this->render('user/updateProfil.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
