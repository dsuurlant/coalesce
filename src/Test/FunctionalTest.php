<?php

declare(strict_types=1);

namespace App\Test;

use App\Entity\User;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\DBAL\Connection;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Makes sure the tests occur in a transaction.
 *
 * @author Daniëlle Suurlant <danielle.suurlant@gmail.com>
 */
class FunctionalTest extends WebTestCase
{
    /**
     * @var KernelBrowser
     */
    protected $client;

    /**
     * @var Connection
     */
    private $connection;

    public function setUp(): void
    {
        $this->client = self::createClient(
            [],
            ['CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'application/json']
        );

        $connection = self::$kernel->getContainer()->get('doctrine.dbal.default_connection');
        $this->connection = $connection;
        $this->connection->beginTransaction();
    }

    /**
     * Helper function to add authorization to the test client.
     */
    protected function setUpAuth(): void
    {
        $user = $this->createUser('testuser@example.org', 'testpass');

        /** @var JWTTokenManagerInterface $jwtManager */
        $jwtManager = self::$kernel->getContainer()->get('lexik_jwt_authentication.jwt_manager');
        $token = $jwtManager->create($user);

        $this->client->setServerParameter('HTTP_AUTHORIZATION', sprintf('Bearer %s', $token));
    }

    protected function createUser(string $username, string $password): User
    {
        /** @var ManagerRegistry $doctrine */
        $doctrine = self::$kernel->getContainer()->get('doctrine');
        /** @var UserPasswordEncoderInterface $encoder */
        $encoder = self::$kernel->getContainer()->get('security.password_encoder');

        $user = new User();
        $user->setUsername($username);
        $user->setPassword($encoder->encodePassword($user, $password));

        $doctrine->getManager()->persist($user);
        $doctrine->getManager()->flush();

        return $user;
    }

    public function tearDown(): void
    {
        $this->connection->rollBack();
        parent::tearDown();
    }
}
