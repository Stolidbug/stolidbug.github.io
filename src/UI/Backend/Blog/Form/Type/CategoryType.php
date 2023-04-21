<?php

declare(strict_types=1);

namespace App\UI\Backend\Blog\Form\Type;

use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => $this->translate('name.label'),
            ])
            ->add('slug', TextType::class, [
                'label' => $this->translate('slug.label'),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }

    private function translate(string $key): string
    {
        return sprintf('backend.blog.ui.category.form.%s', $key);
    }
}
