<?php

declare(strict_types=1);

namespace App\UI\Frontend\Controller\Contact\Form;

use App\Shared\Infrastructure\CheckIfHuman\CaptChaGenerator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    private string $class;

    public function __construct(
        private readonly CaptChaGenerator $captChaGenerator,
    ) {
        $this->class = ContactDTO::class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $captCha = $this->captChaGenerator->generate();

        $builder
            ->add('name', TextType::class, [
                'label' => $this->translate('name.label'),
            ])
            ->add('email', EmailType::class, [
                'label' => $this->translate('email.label'),
            ])
            ->add('message', TextareaType::class, [
                'label' => $this->translate('message.label'),
            ])
            ->add('captchaQuestion', TextType::class, [
                'label' => $this->translate('captcha.question.label'),
                'data' => $captCha['question'],
                'attr' => [
                    'readonly' => true,
                ],
            ])
            ->add('captchaAnswer', HiddenType::class, [
                'data' => $captCha['answer'],
            ])
            ->add('captchaUserAnswer', TextType::class, [
                'label' => $this->translate('captcha.answer.label'),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'factory' => $this->class,
            'immutable' => true,
        ]);
    }

    private function translate(string $key): string
    {
        return sprintf('frontend.contact.create.form.%s', $key);
    }
}
