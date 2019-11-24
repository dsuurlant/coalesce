<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Entity\Connection;
use App\Entity\User;
use App\Repository\ConnectionRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * @author Daniëlle Suurlant <danielle.suurlant@gmail.com>
 */
final class UniqueConnectionValidator extends ConstraintValidator
{
    /** @var TokenStorageInterface */
    private $tokenStorage;
    /** @var ManagerRegistry */
    private $doctrine;
    /** @var ConnectionRepository */
    private $connectionRepository;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        ManagerRegistry $doctrine,
        ConnectionRepository $connectionRepository
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->doctrine = $doctrine;
        $this->connectionRepository = $connectionRepository;
    }

    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof UniqueConnection) {
            throw new UnexpectedTypeException($constraint, UniqueConnection::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        $token = $this->tokenStorage->getToken();
        if (!$token instanceof TokenInterface) {
            return;
        }
        $inviter = $token->getUser();
        $invitee = $this->doctrine->getRepository(User::class)->find(Uuid::fromString($value));

        if (!$inviter instanceof User || !$invitee instanceof User) {
            return;
        }

        // Check if these users are already connected.
        $connection = $this->connectionRepository->findConnectionForUsers($inviter, $invitee);

        if ($connection instanceof Connection) {
            $this->context
                ->buildViolation(UniqueConnection::MESSAGE)
                ->setParameter('{{ userA }}', $inviter->getId())
                ->setParameter('{{ userB }}', $invitee->getId())
                ->addViolation();
        }
    }
}
