<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Entity\User;
use App\Message\Register;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @author Daniëlle Suurlant <danielle.suurlant@gmail.com>
 */
final class RegisterHandler implements MessageHandlerInterface
{
    /** @var UserPasswordEncoderInterface */
    private $userPasswordEncoder;

    /** @var ManagerRegistry */
    private $doctrine;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder, ManagerRegistry $doctrine)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->doctrine = $doctrine;
    }

    public function __invoke(Register $register)
    {
        $repository = $this->doctrine->getRepository(User::class);

        $user = $repository->findOneBy(['username' => $register->getUsername()]);
        if ($user instanceof User) {
            throw new BadRequestHttpException('Username already exists');
        }

        $user = new User();
        $user->setUsername($register->getUsername());
        $user->setPassword(
            $this->userPasswordEncoder->encodePassword($user, $register->getPassword())
        );

        $this->doctrine->getManager()->persist($user);
        $this->doctrine->getManager()->flush();

        return $user;
    }
}
