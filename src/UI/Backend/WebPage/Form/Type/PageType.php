<?php

declare(strict_types=1);

namespace App\UI\Backend\WebPage\Form\Type;

use App\Content\WebPage\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\Page;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => $this->translate('name.label'),
            ])
            ->add('content', TextareaType::class, [
                'label' => $this->translate('content.label'),
            ])
            ->add('author', TextType::class, [
                'label' => $this->translate('author.label'),
            ])
            ->add('status', CheckboxType::class, [
                'label' => $this->translate('status.label'),
            ])
            ->add('slug', TextType::class, [
                'label' => $this->translate('slug.label'),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Page::class,
        ]);
    }

    private function translate(string $key): string
    {
        return sprintf('backend.webpage.ui.page.form.%s', $key);
    }
}
