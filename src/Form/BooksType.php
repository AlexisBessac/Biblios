<?php

namespace App\Form;

use App\Entity\author;
use App\Entity\Books;
use App\Entity\Genre;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BooksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('coverFile', FileType::class, [
                'required' => false,
                'label' => 'Image de couverture',
            ])
            ->add('publishedAt', null, [
                'widget' => 'single_text',
            ])
            ->add('pageNumber')
            ->add('Genre', EntityType::class, [
                'class' => Genre::class,
                'choice_label' => 'name',
                'multiple' => true,
                'autocomplete' => true,

            ])
            ->add('Author', EntityType::class, [
                'class' => author::class,
                'choice_label' => 'name',
            ])
            ->add('description')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Books::class,
        ]);
    }
}
