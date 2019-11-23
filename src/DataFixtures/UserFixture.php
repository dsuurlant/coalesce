<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Create 10 users with randomized emails and passwords.
 *
 * @author Daniëlle Suurlant <danielle.suurlant@gmail.com>
 */
final class UserFixture extends Fixture
{
    /** @var UserPasswordEncoderInterface */
    private $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setUsername($faker->email);
            $user->setPassword(
                $this->userPasswordEncoder->encodePassword($user, $faker->password)
            );
            $manager->persist($user);
        }

        $manager->flush();
    }
}
