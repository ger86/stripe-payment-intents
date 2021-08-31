<?php

namespace App\Repository;

use App\Entity\PaymentOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PaymentOrder|null find($id, $lockMode = null, $lockVersion = null)
 * @method PaymentOrder|null findOneBy(array $criteria, array $orderBy = null)
 * @method PaymentOrder[]    findAll()
 * @method PaymentOrder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @extends \Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository<PaymentOrder>
 */
class PaymentOrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PaymentOrder::class);
    }

    public function save(PaymentOrder $record, bool $withFlush = true): void
    {
        $em = $this->getEntityManager();
        $em->persist($record);
        if ($withFlush) {
            $em->flush();
        }
    }

    public function delete(PaymentOrder $record): void
    {
        $em = $this->getEntityManager();
        $em->remove($record);
        $em->flush();
    }
}
