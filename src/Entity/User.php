<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @author Daniëlle Suurlant <danielle.suurlant@gmail.com>
 */
class User implements UserInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var Collection
     */
    private $myConnections;

    /**
     * @var Collection
     */
    private $connectedToMe;

    public function __construct()
    {
        $this->id = Uuid::uuid4()->toString();
        $this->myConnections = new ArrayCollection();
        $this->connectedToMe = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void
    {
        return;
    }

    public function getMyConnections(): Collection
    {
        return $this->myConnections;
    }

    public function setMyConnections(Collection $myConnections): self
    {
        $this->myConnections = $myConnections;

        return $this;
    }

    public function getConnectedToMe(): Collection
    {
        return $this->connectedToMe;
    }

    public function setConnectedToMe(Collection $connectedToMe): self
    {
        $this->connectedToMe = $connectedToMe;

        return $this;
    }
}
