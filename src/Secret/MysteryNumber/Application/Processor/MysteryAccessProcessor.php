<?php

declare(strict_types=1);

namespace App\Secret\MysteryNumber\Application\Processor;

class MysteryAccessProcessor
{
    public function checkAccess(array $data): bool
    {
        if ($data['email'] === 'secret@example.com' && $data['name'] === 'John Doe' && $data['message'] === 'secret code') {
            return true;
        }

        return false;
    }
}
