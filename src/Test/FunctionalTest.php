<?php

declare(strict_types=1);

namespace App\Test;

use App\Entity\User;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\DBAL\Connection;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTManager;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

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
        /** @var ManagerRegistry $doctrine */
        $doctrine = self::$kernel->getContainer()->get('doctrine');
        $users = $doctrine->getRepository(User::class)->findAll();

        if (0 === count($users)) {
            throw new RuntimeException('Add users to the test database first by running "doctrine:fixtures:load" before running your tests.');
        }
        $user = reset($users);

        /** @var JWTTokenManagerInterface $jwtManager */
        $jwtManager = self::$kernel->getContainer()->get('lexik_jwt_authentication.jwt_manager');
        $token = $jwtManager->create($user);

        $this->client->setServerParameter('HTTP_AUTHORIZATION', sprintf('Bearer %s', $token));
    }

    public function tearDown(): void
    {
        $this->connection->rollBack();
        parent::tearDown();
    }
}
