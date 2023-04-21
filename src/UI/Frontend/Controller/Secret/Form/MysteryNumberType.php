<?php

declare(strict_types=1);

namespace App\UI\Frontend\Controller\Secret\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;

class MysteryNumberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('guess', IntegerType::class, [
                'label' => 'Entrez un nombre :',
            ])
        ;
    }
}
