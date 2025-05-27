<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AccountController extends AbstractController
{
    #[Route('/account', name: 'app_account')]
    public function index(EntityManagerInterface $em): Response
    {

        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        if (in_array($user->getStatut(), ['chauffeur', 'mixte'], true) && $user->getVehicules()->isEmpty()) {
            return $this->redirectToRoute('app_vehicule_new');
        }

        if (in_array($user->getStatut(), ['chauffeur', 'mixte'], true) && $user->getPreference()->isEmpty()) {
            return $this->redirectToRoute('app_preference_new');
        }

        return $this->render('account/index.html.twig', [
            'user' => $user,
        ]);
    }


    #[Route('/account/become-chauffeur', name: 'app_account_become_chauffeur')]
    public function becomeChauffeur(EntityManagerInterface $em): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $nouveauStatut = $user->getStatut() === 'passager' ? 'mixte' : 'chauffeur';
        $user->setStatut($nouveauStatut);
        $em->flush();

        return $this->redirectToRoute('app_account');
    }
}
