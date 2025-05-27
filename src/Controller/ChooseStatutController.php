<?php

namespace App\Controller;

use App\Form\ChooseStatutType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ChooseStatutController extends AbstractController
{
    #[Route('/choose_statut', name: 'app_choose_statut')]
    public function choose(Request $request, EntityManagerInterface $em): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        if (null !== $user->getStatut()) {
            return $this->redirectToRoute('app_account');
        }

        $form = $this->createForm(ChooseStatutType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('app_account');
        }

        return $this->render('account/choose_statut.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
