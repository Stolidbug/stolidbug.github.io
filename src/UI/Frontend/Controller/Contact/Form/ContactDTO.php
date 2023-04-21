<?php

declare(strict_types=1);

namespace App\UI\Frontend\Controller\Contact\Form;

class ContactDTO
{
    public function __construct(
        private readonly string $name,
        private readonly string $email,
        private readonly string $message,
        private readonly string $captchaQuestion,
        private readonly string $captchaAnswer,
        private readonly string $captchaUserAnswer,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getCaptchaQuestion(): string
    {
        return $this->captchaQuestion;
    }

    public function getCaptchaAnswer(): string
    {
        return $this->captchaAnswer;
    }

    public function getCaptchaUserAnswer(): string
    {
        return $this->captchaUserAnswer;
    }

    /**
     * @return array<string,string>
     */
    public function getData(): array
    {
        return [
            'name' => $this->name,
            'mail' => $this->email,
            'message' => $this->message,
            'captchaQuestion' => $this->captchaQuestion,
            'captchaAnswer' => $this->captchaAnswer,
            'captchaUserAnswer' => $this->captchaUserAnswer,
        ];
    }
}
