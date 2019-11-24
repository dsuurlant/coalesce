<?php

declare(strict_types=1);

namespace App\Message;

/**
 * Invite another user to connect.
 *
 * @author Daniëlle Suurlant <danielle.suurlant@gmail.com>
 */
final class Invite
{
    /**
     * The id of the user to invite.
     *
     * @var string
     */
    private $userId;

    /**
     * The message to send to the invited user.
     *
     * @var string
     */
    private $message;

    public function __construct(string $userId, string $message)
    {
        $this->userId = $userId;
        $this->message = $message;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
