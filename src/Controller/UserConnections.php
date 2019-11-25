<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Repository\ConnectionRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author Daniëlle Suurlant <danielle.suurlant@gmail.com>
 */
final class UserConnections
{
    /** @var ConnectionRepository */
    private $connectionRepository;
    /** @var ManagerRegistry */
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine, ConnectionRepository $connectionRepository)
    {
        $this->connectionRepository = $connectionRepository;
        $this->doctrine = $doctrine;
    }

    public function __invoke(string $id, Request $request): array
    {
        $user = $this->doctrine->getRepository(User::class)->find($id);
        if (!$user instanceof User) {
            throw new NotFoundHttpException('User not found.');
        }

        return $this->connectionRepository->findConnectionsForUser($user);
    }
}
