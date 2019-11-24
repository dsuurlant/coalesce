<?php

declare(strict_types=1);

namespace App\Test;

use Doctrine\DBAL\Connection;
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

        $connection       = self::$kernel->getContainer()->get('doctrine.dbal.default_connection');
        $this->connection = $connection;
        $this->connection->beginTransaction();
    }

    public function tearDown(): void
    {
        $this->connection->rollBack();
        parent::tearDown();
    }
}
