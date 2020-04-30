<?php

namespace App\Repository;

use App\Entity\Property;
use App\Entity\PropertySearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Property::class);
    }
     public function findLatest()
    {
        return $this->createQueryBuilder('p')
                    ->where('p.sold=false') 
                ->setMaxResults(10)
                    ->getQuery()
                ->getResult();
        
    }
    public function findAllVisible(PropertySearch $search)
    {
        $query=$this->createQueryBuilder('p')
                    ->andWhere('p.sold=false');
        if($search->getMaxPrice()){
            $query=$query->andWhere('p.price<=:maxprice')
                          ->setParameter('maxprice',$search->getMaxPrice());
        }
        if($search->getMinSurface()){
            $query=$query->where('p.surface>=:minsurface')
                          ->setParameter('minsurface',$search->getMinSurface());
        }
        if($search->getOptions()->count()>0){
          $k=0;
            foreach($search->getOptions()as $option){
                $k++;
                $query=$query->andWhere(":option$k MEMBER OF p.options")
                             ->setParameter("option$k", $option);
            }
        }
                 return $query->getQuery();  
    }        
                 public function getCountPosts()
                 {
                     $qb= $this->createQueryBuilder('p');
                     $qb->select(
                     $qb->expr()->count('p.id')
                     );
                     return $qb->getQuery()->getSingleScalarResult();
                 }

                 public function getPosts(?int $offset=0, int $limit=10)
                 {
                     $qb= $this->createQueryBuilder('p');
                     $qb->select()
                     ->setFirstResult($offset)
                        ->setMaxResults($limit)
                     ;
                     return $qb->getQuery()->getArrayResult();
                 }
    
    // /**
    //  * @return Property[] Returns an array of Property objects
    //  */
    /*
    
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Property
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
