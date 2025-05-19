<?php

namespace App\Repository;

use App\Entity\Trajet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Trajet>
 */
class TrajetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trajet::class);
    }


    public function searchTrips(string $from, string $to, \DateTimeInterface $date): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = <<<SQL

        SELECT
            t.id_trajet, 
            t.adresse_depart, 
            t.adresse_arrivee, 
            DATE_FORMAT(t.date_depart, '%Y-%m-%d %H:%i') AS date_depart, 
            t.prix,
            t.places_restantes, 
            u.pseudo AS chauffeur
        FROM trajet AS t
        JOIN utilisateur u ON t.chauffeur_id = u.id_utilisateur
        WHERE 
            t.adresse_depart = ?
            AND t.adresse_arrivee = ?
            AND DATE(t.date_depart) = ?
            AND t.places_restantes > 0
        ORDER BY t.date_depart
        SQL;

        return $conn->executeQuery($sql, [
            $from,
            $to,
            $date->format('Y-m-d'),
        ])->fetchAllAssociative();
    }

    //    /**
    //     * @return Trajet[] Returns an array of Trajet objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Trajet
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
