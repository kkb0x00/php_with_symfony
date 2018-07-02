<?php

namespace App\Repository;

use App\Entity\District;
use function Couchbase\defaultDecoder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method District|null find($id, $lockMode = null, $lockVersion = null)
 * @method District|null findOneBy(array $criteria, array $orderBy = null)
 * @method District[]    findAll()
 * @method District[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DistrictRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, District::class);
    }

    /**
     * @param $values
     * @return array Returns an array of District objects
     */

    public function findByFilter($values): array
    {
        $builder = $this->createQueryBuilder('d');

        foreach ($values as $param => $value) {
            switch($param) {
                case 'miasto':
                    $builder
                        ->andWhere('d.miasto LIKE :miasto')
                        ->setParameter('miasto', '%'.$value.'%');
                    break;
                case 'dzielnica':
                    $builder
                        ->andWhere('d.dzielnica LIKE :dzielnica')
                        ->setParameter('dzielnica', '%'.$value.'%');
                    break;
                case 'ludnosc_od':
                    $builder
                        ->andWhere('d.ludnosc >= :ludnosc_od')
                        ->setParameter('ludnosc_od', $value);
                    break;
                case 'ludnosc_do':
                    $builder
                        ->andWhere('d.ludnosc <= :ludnosc_do')
                        ->setParameter('ludnosc_do', $value);
                    break;
                case 'powierzchnia_od':
                    $builder
                        ->andWhere('d.powierzchnia > :powierzchnia_od')
                        ->setParameter('powierzchnia_od', $value);
                    break;
                case 'powierzchnia_do':
                    $builder
                        ->andWhere('d.powierzchnia < :powierzchnia_do')
                        ->setParameter('powierzchnia_do', $value);
                    break;
            }
        }

        return $builder->getQuery()->getResult();
    }

    public function sortByColumn($column, $direction)
    {
        $sort_type = $direction == 'descending' ? 'DESC' : 'ASC';

        $builder = $this->createQueryBuilder('d');

        switch($column) {
            case 'miasto':
                $builder->orderBy('d.miasto', $sort_type);
                break;
            case 'dzielnica':
                $builder->orderBy('d.dzielnica', $sort_type);
                break;
            case 'ludnosc':
                $builder->orderBy('d.ludnosc', $sort_type);
                break;
            case 'powierzchnia':
                $builder->orderBy('d.powierzchnia', $sort_type);
                break;
        }

        return $builder->getQuery()->getResult();
    }


    /*
    public function findOneBySomeField($value): ?District
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
