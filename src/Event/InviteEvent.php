<?php

declare(strict_types=1);

namespace App\Event;

use App\Entity\Connection;
use App\Message\Invite;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * @author Daniëlle Suurlant <danielle.suurlant@gmail.com>
 */
final class InviteEvent extends Event
{
    public const NAME = 'app.event.invite';

    /**
     * @var Invite
     */
    private $invite;

    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Invite $invite, Connection $connection)
    {
        $this->invite = $invite;
        $this->connection = $connection;
    }

    public function getInvite(): Invite
    {
        return $this->invite;
    }

    public function getConnection(): Connection
    {
        return $this->connection;
    }
}
