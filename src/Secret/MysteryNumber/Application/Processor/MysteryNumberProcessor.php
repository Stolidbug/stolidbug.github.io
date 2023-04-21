<?php

declare(strict_types=1);

namespace App\Secret\MysteryNumber\Application\Processor;

use Symfony\Contracts\Translation\TranslatorInterface;

class MysteryNumberProcessor
{
    private const MAX_TRIES = 10;
    public function __construct(
        private readonly TranslatorInterface $translator,
    ) {
    }

    private function generateRandomNumber(int $max): int
    {
        return random_int(1, $max);
    }

    public function process(int $mysteryNumber, int $guess, int $tries, int $difficulty, array $previousNumbers = []): array
    {
        $tries++;

        if (($difficulty % 500) === 0) {
            return $this->processBossLevel($mysteryNumber, $guess, $tries, $difficulty, $previousNumbers);
        }

        return $this->processNormalLevel($mysteryNumber, $guess, $tries, $difficulty, $previousNumbers);
    }

    private function processBossLevel(int $mysteryNumber, int $guess, int $tries, int $difficulty, array $previousNumbers): array
    {
        $newDifficulty = $difficulty;
        $lost = false;
        $sumOfPreviousNumbers = array_sum($previousNumbers);

        if ($guess === $sumOfPreviousNumbers) {
            $message = $this->translator->trans('frontend.game.processor.congratulations', ['tries' => $tries]);
            $newDifficulty += 100;
            $mysteryNumber = $this->generateRandomNumber($newDifficulty);
            $tries = 0;
            $message .= " " . $this->translator->trans('frontend.game.processor.difficulty_increase', ['newDifficulty' => $newDifficulty]);
            $previousNumbers = [];
        } else {
            $message = $this->translator->trans('frontend.game.processor.boss_incorrect_sum');
            if ($tries === self::MAX_TRIES) {
                $message .= " " . $this->translator->trans('frontend.game.processor.out_of_tries', ['mysteryNumber' => $sumOfPreviousNumbers]);
                $mysteryNumber = $this->generateRandomNumber($difficulty);
                $tries = 0;
                $lost = true;
            }
        }

        return [
            'mystery_number' => $mysteryNumber,
            'tries' => $tries,
            'message' => $message,
            'difficulty' => $newDifficulty,
            'lost' => $lost,
            'previous_numbers' => $previousNumbers,
        ];
    }

    private function processNormalLevel(int $mysteryNumber, int $guess, int $tries, int $difficulty, array $previousNumbers): array
    {
        $newDifficulty = $difficulty;
        $lost = false;

        if ($guess === $mysteryNumber) {
            $message = $this->translator->trans('frontend.game.processor.congratulations', ['tries' => $tries]);
            $newDifficulty += 100;
            $previousNumbers[] = $mysteryNumber;
            $mysteryNumber = $this->generateRandomNumber($newDifficulty);
            $tries = 0;
            $message .= " " . $this->translator->trans('frontend.game.processor.difficulty_increase', ['newDifficulty' => $newDifficulty]);
        } else {
            $message = match (true) {
                $guess < $mysteryNumber => $this->translator->trans('frontend.game.processor.number_greater'),
                default => $this->translator->trans('frontend.game.processor.number_smaller'),
            };

            if ($tries === self::MAX_TRIES) {
                $message .= " " . $this->translator->trans('frontend.game.processor.out_of_tries', ['mysteryNumber' => $mysteryNumber]);
                $mysteryNumber = $this->generateRandomNumber($difficulty);
                $tries = 0;
                $lost = true;
            }
        }

        return [
            'mystery_number' => $mysteryNumber,
            'tries' => $tries,
            'message' => $message,
            'difficulty' => $newDifficulty,
            'lost' => $lost,
            'previous_numbers' => $previousNumbers,
        ];
    }
}
