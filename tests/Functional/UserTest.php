<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Entity\User;
use App\Test\FunctionalTest;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;

/**
 * Tests user functionality.
 *
 * @author Daniëlle Suurlant <danielle.suurlant@gmail.com>
 */
final class UserTest extends FunctionalTest
{
    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    public function setUp(): void
    {
        parent::setUp();
        $this->setUpAuth();

        $this->doctrine = self::$kernel->getContainer()->get('doctrine');
    }

    public function testReadAllContacts(): void
    {
        $this->client->request('GET', '/api/users');

        $users = $this->doctrine->getRepository(User::class)->findAll();

        $response = $this->client->getResponse();
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $responseUsers = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);
        self::assertCount(count($users), $responseUsers);
    }

    public function testUserCanRegister(): void
    {
        $register = [
            'username' => sprintf('%s@example.org', bin2hex(random_bytes(16))),
            'password' => 'testpassword',
        ];
        $this->client->request('POST', '/api/register', [], [], [], json_encode($register, JSON_THROW_ON_ERROR));
        $response = $this->client->getResponse();

        self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $user = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);
        self::assertArrayHasKey('id', $user);
        self::assertArrayHasKey('username', $user);
    }

    public function testInviteAUserToConnect(): void
    {
        $users = $this->doctrine->getRepository(User::class)->findAll();

        $invite = [
            'userId' => '',
            'message' => 'Want to be my friend?'
        ];
    }
}
