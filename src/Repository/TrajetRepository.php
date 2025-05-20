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


    public function searchTrips(string $from, string $to, \DateTimeInterface $date, bool $eco = false, ?int $maxPrice = null, ?int $maxDuration = null, ?float $minRating = null): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = <<<SQL

        SELECT
            t.id_trajet, 
            t.adresse_depart, 
            t.adresse_arrivee, 
            DATE_FORMAT(t.date_depart, '%Y-%m-%d %H:%i') AS date_depart, 
            DATE_FORMAT(t.date_arrivee, '%Y-%m-%d %H:%i') AS date_arrivee, 
            t.prix,
            t.places_restantes, 
            u.pseudo AS chauffeur,
            COALESCE(ar.avg_rating, 0) AS avg_rating,
            v.electrique AS vehicule_electrique
        FROM trajet AS t
        JOIN utilisateur AS u 
            ON t.chauffeur_id = u.id_utilisateur
        JOIN vehicule as v 
            ON t.vehicule_id = v.id_vehicule
        
        LEFT JOIN (
            SELECT 
                t2.chauffeur_id,
                AVG(a.note) AS avg_rating
            FROM reservation r2
            JOIN avis a 
                ON r2.id_reservation = a.reservation_id
            JOIN trajet t2
                ON r2.trajet_id = t2.id_trajet
            WHERE a.statut_validation = 'valide'
            GROUP BY t2.chauffeur_id 
        ) AS ar 
            ON ar.chauffeur_id = t.chauffeur_id 

        WHERE 
            t.adresse_depart = ?
            AND t.adresse_arrivee = ?
            AND DATE(t.date_depart) = ?
            AND t.places_restantes > 0
        SQL;

        $params = [
            $from,
            $to,
            $date->format('Y-m-d'),
        ];

        if ($eco) {
            $sql .= " AND v.electrique = 1";
        }

        if ($maxPrice !== null) {
            $sql .= " AND t.prix <= ?";
            $params[] = $maxPrice;
        }

        if ($maxDuration !== null) {
            $sql .= " AND TIMESTAMPDIFF(MINUTE, t.date_depart, t.date_arrivee) <= ?";
            $params[] = $maxDuration;
        }

        if ($minRating !== null) {
            $sql .= " AND COALESCE(ar.avg_rating, 0) >= ?";
            $params[] = $minRating;
        }

        $sql .= " ORDER BY t.date_depart";

        return $conn->executeQuery($sql, $params)->fetchAllAssociative();
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
                DATE_FORMAT(t.date_arrivee, '%Y-%m-%d %H:%i') AS date_arrivee, 
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

    public function findNextAvailableTripDate(string $from, string $to, \DateTimeInterface $date): ?\DateTimeImmutable
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = <<<SQL
        SELECT MIN(t.date_depart) AS next_date
        FROM trajet t 
        WHERE t.adresse_depart = ?
            AND t.adresse_arrivee = ?
            AND t.date_depart > ?
            AND t.places_restantes > 0
        SQL;

        $row = $conn->executeQuery($sql, [
            $from,
            $to,
            $date->format('Y-m-d H:i:s'),
        ])->fetchAssociative();

        if (empty($row['next_date'])) {
            return null;
        }

        return new \DateTimeImmutable($row['next_date']);
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
