<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Connection;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;

/**
 * @author Daniëlle Suurlant <danielle.suurlant@gmail.com>
 */
final class ConnectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $doctrine)
    {
        parent::__construct($doctrine, Connection::class);
    }

    /**
     * Check if these users are already connected by either side of the possible connection.
     *
     * @return mixed|null
     */
    public function findConnectionForUsers(User $userA, User $userB): ?Connection
    {
        $qb = $this
            ->createQueryBuilder('c')
            ->where('c.userA = :userA AND c.userB = :userB')
            ->orWhere('c.userB = :userA AND c.userA = :userB')
            ->setParameters(
                [
                    'userA' => $userA,
                    'userB' => $userB,
                ]
            )
            ->setMaxResults(1);

        try {
            return $qb->getQuery()->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            return null;
        }
    }

    public function findConnectionsForUser(User $user): array
    {
        $qb = $this
            ->createQueryBuilder('c')
            ->where('c.userA = :user')
            ->orWhere('c.userB = :user')
            ->setParameter('user', $user);

        return $qb->getQuery()->getResult();
    }
}
