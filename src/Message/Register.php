<?php declare(strict_types=1);

namespace App\Message;

/**
 * Message from user who wants to register.
 *
 * @author Daniëlle Suurlant <danielle.suurlant@gmail.com>
 */
final class Register
{
    /** @var string */
    private $username;

    /** @var string */
    private $password;

    /**
     * @param string $username
     * @param string $password
     */
    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}
