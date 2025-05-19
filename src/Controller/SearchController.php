<?php

namespace App\Controller;

use App\Repository\TrajetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\VarDumper\VarDumper;

final class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function search(Request $request, TrajetRepository $repo): Response
    {

        $from = $request->query->get('depart', '');
        $to = $request->query->get('arrivee', '');
        $date = new \DateTime($request->query->get('date', 'now'));

        VarDumper::dump([
            'from' => $from,
            'to' => $to,
            'date' => $date->format('Y-m-d'),
        ]);

        $trajets = $repo->searchTrips($from, $to, $date);

        return $this->render('search/results.html.twig', [
            'trajets' => $trajets,
        ]);
    }

    #[Route('/trajet/{id}', name: 'app_trajet_detail', requirements: ['id' => '\d+'])]
    public function detail(int $id, TrajetRepository $repo): Response
    {

        $trip = $repo->findTripById($id);
        if (empty($trip)) {
            throw $this->createNotFoundException("Trajet #$id introuvable");
        }

        $reviews = $repo->getTripReviews($id);

        return $this->render('search/details.html.twig', [
            'trip' => $trip,
            'reviews' => $reviews,
        ]);
    }
}
