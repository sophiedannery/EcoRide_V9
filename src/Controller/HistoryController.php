<?php

namespace App\Controller;

use App\Repository\ReservationRepository;
use App\Repository\TrajetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HistoryController extends AbstractController
{
    #[Route('/history', name: 'app_history')]
    public function index(ReservationRepository $reservation_repository, TrajetRepository $trajet_repository): Response
    {

        $user = $this->getUser();

        // QueryBuilder : on joint le trajet pour pouvoir filtrer par trajet.chauffeurs
        $qb = $reservation_repository->createQueryBuilder('r')
            ->leftJoin('r.trajet', 't')
            ->addSelect('t')
            ->andWhere('r.passagers = :user OR t.chauffeurs = :user')
            ->setParameter('user', $user)
            ->orderBy('r.dateConfirmation', 'DESC');

        $reservations = $qb->getQuery()->getResult();




        return $this->render('history/index.html.twig', [
            'reservations' => $reservations,
        ]);
    }
}
