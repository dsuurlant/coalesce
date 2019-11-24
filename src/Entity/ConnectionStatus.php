<?php

declare(strict_types=1);

namespace App\Entity;

/**
 * Represents connection statuses.
 *
 * @author Daniëlle Suurlant <danielle@connectholland.nl>
 */
interface ConnectionStatus
{
    /**
     * Represents an invited connection.
     *
     * @var string
     */
    public const INVITED = 'invited';

    /**
     * Represents an open connection.
     *
     * @var string
     */
    public const OPEN = 'open';

    /**
     * Represents a closed connection.
     *
     * @var string
     */
    public const CLOSED = 'closed';
}
