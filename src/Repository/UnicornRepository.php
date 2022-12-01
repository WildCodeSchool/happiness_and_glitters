<?php

namespace App\Repository;

use App\Entity\Unicorn;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Unicorn>
 *
 * @method Unicorn|null find($id, $lockMode = null, $lockVersion = null)
 * @method Unicorn|null findOneBy(array $criteria, array $orderBy = null)
 * @method Unicorn[]    findAll()
 * @method Unicorn[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UnicornRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Unicorn::class);
    }

    public function save(Unicorn $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Unicorn $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function find3ByRand(int $id): array
    {
        $sqlQuery = "SELECT u FROM App\Entity\Unicorn u";
        $query = $this->entityManager->createQuery($sqlQuery);
        $result = $query->getResult();
        $count = count($result);
        $unicorns = array();
        for ($i = 0; count($unicorns) < 3; $i++) {
            $unicorn = $result[rand(0, $count - 1)];
            if ($unicorn->getId() != $id && !in_array($unicorn, $unicorns)) {
                $unicorns[] = $unicorn;
            }
        }
        return $unicorns;
    }

    //    /**
    //     * @return Unicorn[] Returns an array of Unicorn objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Unicorn
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
