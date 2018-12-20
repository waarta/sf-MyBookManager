<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class MarquePageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextareaType::class, ['label' => 'titre'])
            ->add('URL', TextareaType::class, ['label' => 'url'])
            ->add('commentaire', TextareaType::class, ['label' => 'commentaire'])
            ->add('save', SubmitType::class);

    }
}
