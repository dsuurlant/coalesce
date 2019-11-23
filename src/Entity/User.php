<?php declare(strict_types=1);

namespace App\Entity;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @author Daniëlle Suurlant <danielle.suurlant@gmail.com>
 */
final class User implements UserInterface
{
    /**
     * @var UuidInterface
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

    public function __construct()
    {
        $this->id = Uuid::uuid4();
    }

    public function getId(): UuidInterface
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
}
