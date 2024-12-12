<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Books;
use App\Entity\Genre;
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
            ->add('name')
            ->add('cover', FileType::class, [
                'mapped' => false,
                'label' => "Image de couverture"
            ])
            ->add('description')
            ->add('page_number')
            ->add('published_at', null, [
                'widget' => 'single_text',
            ])
            ->add('author', EntityType::class, [
                'class' => Author::class,
                'choice_label' => 'name',
                'autocomplete' => true
            ])
            ->add('genres', EntityType::class, [
                'class' => Genre::class,
                'choice_label' => 'name',
                'multiple' => true,
                'autocomplete' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Books::class,
        ]);
    }
}
