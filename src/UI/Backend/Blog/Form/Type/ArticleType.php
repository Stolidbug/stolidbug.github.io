<?php

declare(strict_types=1);

namespace App\UI\Backend\Blog\Form\Type;

use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\Article;
use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\Author;
use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\Category;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => $this->translate('title.label'),
            ])
            ->add('content', CKEditorType::class, [
                'label' => $this->translate('content.label'),
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'label' => $this->translate('categories.label'),
                'multiple' => true,
            ])
            ->add('authors', EntityType::class, [
                'class' => Author::class,
                'choice_label' => 'name',
                'label' => $this->translate('authors.label'),
                'multiple' => true,

            ])
            ->add('image', FileType::class, [
                'label' => $this->translate('image.label'),
                'mapped' => false,
                'required' => false,
            ])
            ->add('slug', TextType::class, [
                'label' => $this->translate('slug.label'),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }

    private function translate(string $key): string
    {
        return sprintf('backend.blog.ui.article.form.%s', $key);
    }
}
