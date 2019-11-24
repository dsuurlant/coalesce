<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 *
 * @author Daniëlle Suurlant <danielle.suurlant@gmail.com>
 */
final class UniqueConnection extends Constraint
{
    public const MESSAGE = 'There is an existing connection between user {{ userA }} and user {{ userB }}.';
}
