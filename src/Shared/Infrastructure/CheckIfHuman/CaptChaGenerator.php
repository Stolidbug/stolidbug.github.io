<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\CheckIfHuman;

class CaptChaGenerator
{
    public function generate(): array
    {
        $num1 = random_int(1, 20);
        $num2 = random_int(1, 10);
        $question = sprintf('%d + %d', $num1, $num2);
        $answer = $num1 + $num2;

        return ['question' => $question, 'answer' => $answer];
    }
}
