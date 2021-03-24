<?php

namespace App\Repository;

use App\Entity\Filtre;
use App\Entity\Sortie;
use App\Form\FiltreType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortiesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    public function filtrer($user, Filtre $filtre){

        //on récupère les valeurs du filtre
        $orga = $filtre->getOrga(); // organisateur ?

        $inscrit = $filtre->getInscrit();
        $pasInscrit = $filtre->getPasInscrit();
        $campus = $filtre->getCampus();
        if(empty($campus)){
            $idCampus = 3;
        }
        else {
            $idCampus = $campus->getId();
        }

        $search = $filtre->getSearch();
       if(empty($search)){
            $search='';
        }
        $dateDebut = $filtre->getDateDebut();
        $dateFin = $filtre->getDateFin();
        $past = $filtre->getClose();



       $result = $this->createQueryBuilder('s')
           ->leftJoin('s.campus', 'c')
           ->where('s.date_debut >= :debut and s.date_cloture <= :fin') // gestion date
           ->setParameter('debut', $dateDebut)
           ->setParameter('fin', $dateFin)
           ->andWhere('c.id = :campus') //gsestion campus
           ->setParameter('campus', $idCampus)
           ->andWhere('locate(:search, s.nom)!=0 ') //gestion 'mot appartient au nom'
           ->setParameter('search', $search)
           ->andWhere(':orga = false or s.organisateur = :user')
           ->setParameter('orga', $orga)
           ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
        return $result;
    }


    // /**
    //  * @return Sorties[] Returns an array of Sorties objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Sorties
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
