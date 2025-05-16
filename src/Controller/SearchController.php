<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function search(Request $request): Response
    {

        $depart = $request->query->get('depart');
        $arrivee = $request->query->get('arrivee');
        $date = $request->query->get('date');

        $allrides = [
            [
                'id' => 1,
                'driver' => 'Laura',
                'vehicle' => 'Tesla',
                'price' => 18,
                'depart' => 'Paris',
                'arrivee' => 'Lyon',
                'date' => '2025-06-01',
            ],
            [
                'id' => 2,
                'driver' => 'Luca',
                'vehicle' => 'Ferrari',
                'price' => 23,
                'depart' => 'Marseille',
                'arrivee' => 'Nice',
                'date' => '2025-06-01',
            ],
            [
                'id' => 3,
                'driver' => 'Victoria',
                'vehicle' => 'Petit Poney',
                'price' => 7,
                'depart' => 'Paris',
                'arrivee' => 'Lyon',
                'date' => '2025-06-02',
            ],
            [
                'id' => 4,
                'driver' => 'Nine',
                'vehicle' => 'Kinderkraft',
                'price' => 4,
                'depart' => 'Paris',
                'arrivee' => 'Lyon',
                'date' => '2025-06-01',
            ],

        ];

        $rides = array_filter($allrides, function (array $ride) use ($depart, $arrivee, $date) {
            return $ride['depart'] === $depart && $ride['arrivee'] === $arrivee && $ride['date'] === $date;
        });


        return $this->render('search/results.html.twig', [
            'depart' => $depart,
            'arrivee' => $arrivee,
            'date' => $date,
            'rides' => $rides,
        ]);
    }
}
