<?php

declare(strict_types=1);

namespace App\Entity;

use Ramsey\Uuid\Uuid;

/**
 * Represents a connection between two users.
 *
 * @author Daniëlle Suurlant <danielle.suurlant@gmail.com>
 */
final class Connection
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var User
     */
    private $userA;

    /**
     * @var User
     */
    private $userB;

    /**
     * @var string
     */
    private $status;

    public function __construct()
    {
        $this->id = Uuid::uuid4()->toString();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUserA(): User
    {
        return $this->userA;
    }

    public function setUserA(User $userA): self
    {
        $this->userA = $userA;

        return $this;
    }

    public function getUserB(): User
    {
        return $this->userB;
    }

    public function setUserB(User $userB): self
    {
        $this->userB = $userB;

        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
}
