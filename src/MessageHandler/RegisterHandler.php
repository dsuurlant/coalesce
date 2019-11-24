<?php declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\Register;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * @author Daniëlle Suurlant <danielle.suurlant@gmail.com>
 */
final class RegisterHandler implements MessageHandlerInterface
{
    public function __invoke(Register $register)
    {
        dump($register);
        die;
    }

}
