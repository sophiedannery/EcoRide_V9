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

    public function findTripById(int $id): array
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
                u.id_utilisateur AS chauffeur_id,
                u.pseudo AS chauffeur,
                v.marque AS vehicule_marque,
                v.modele AS vehicule_modele,
                v.electrique AS vehicule_electrique
            FROM trajet AS t
            JOIN utilisateur AS u
                ON t.chauffeur_id = u.id_utilisateur
            JOIN vehicule as v 
                ON t.vehicule_id = v.id_vehicule
            WHERE t.id_trajet = ?
        SQL;

        $trip = $conn->executeQuery($sql, [$id])->fetchAssociative();

        return $trip ?: [];
    }

    public function getTripReviews(int $tripId): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = <<<SQL
        SELECT  
            a.note,
            a.commentaire, 
            DATE_FORMAT(a.date_creation, '%Y-%m-%d %H:%i') AS date_creation,
            p.pseudo AS passager
        FROM reservation r
        JOIN avis a
            ON r.id_reservation = a.reservation_id
        JOIN utilisateur p 
            ON r.passager_id = p.id_utilisateur
        WHERE r.trajet_id = ?
            AND a.statut_validation = 'valide'
        ORDER BY a.date_creation DESC
        SQL;

        return $conn->executeQuery($sql, [$tripId])->fetchAllAssociative();
    }

    public function getDriverPreferences(int $chauffeurId): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = <<<SQL
        SELECT p.libelle
            FROM utilisateur_preference up 
            JOIN preference p 
                ON up.preference_id = p.id_preference
            WHERE up.utilisateur_id = ?
        SQL;

        $rows = $conn->executeQuery($sql, [$chauffeurId])->fetchAllAssociative();

        return array_column($rows, 'libelle');
    }

    public function getDriverAverageRating(int $chauffeurId): ?float
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = <<<SQL
        SELECT AVG(a.note) AS avg_rating
        FROM reservation r 
        JOIN avis a 
            ON r.id_reservation = a.reservation_id
        JOIN trajet t 
            ON r.trajet_id = t.id_trajet
        WHERE t.chauffeur_id = ?
            AND a.statut_validation = 'valide'
        SQL;

        $row = $conn->executeQuery($sql, [$chauffeurId])->fetchAssociative();

        return isset($row['avg_rating']) && $row['avg_rating'] !== null ? (float) $row['avg_rating'] : null;
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
