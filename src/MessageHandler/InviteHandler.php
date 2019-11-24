<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Entity\Connection;
use App\Entity\ConnectionStatus;
use App\Entity\User;
use App\Event\InviteEvent;
use App\Message\Invite;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * @author Daniëlle Suurlant <danielle.suurlant@gmail.com>
 */
final class InviteHandler implements MessageHandlerInterface
{
    /** @var TokenStorageInterface */
    private $tokenStorage;
    /** @var ManagerRegistry */
    private $doctrine;
    /** @var EventDispatcherInterface */
    private $dispatcher;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        ManagerRegistry $doctrine,
        EventDispatcherInterface $dispatcher
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->doctrine = $doctrine;
        $this->dispatcher = $dispatcher;
    }

    public function __invoke(Invite $invite)
    {
        $inviter = $this->tokenStorage->getToken()->getUser();
        $invitee = $this->doctrine->getRepository(User::class)->find($invite->getUserId());
        if (!$invitee instanceof User) {
            throw new BadRequestHttpException('User not found');
        }

        $connection = new Connection();
        $connection->setUserA($inviter);
        $connection->setUserB($invitee);
        $connection->setStatus(ConnectionStatus::INVITED);
        $this->doctrine->getManager()->persist($connection);
        $this->doctrine->getManager()->flush();

        // Dispatch an event so we can tie other actions to this later (i.e. send an email, log message, etc.)
        $inviteEvent = new InviteEvent($invite, $connection);
        $this->dispatcher->dispatch($inviteEvent, InviteEvent::NAME);

        return $connection;
    }
}
