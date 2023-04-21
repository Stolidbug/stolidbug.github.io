<?php

declare(strict_types=1);

namespace App\Secret\MysteryNumber\Application\Provider;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class MysteryNumberProvider
{
    public function initializeGame(SessionInterface $session): void
    {
        if (!$session->has('mysteryNumber')) {
            $session->set('mysteryNumber', mt_rand(1, 100));
            $session->set('tries', 0);
            $session->set('difficulty', 100);
            $session->set('previous_numbers', []);
        }
    }

    public function resetGame(SessionInterface $session): void
    {
        $session->remove('mysteryNumber');
        $session->remove('tries');
        $session->remove('difficulty');
        $session->remove('previous_numbers');
    }
}
