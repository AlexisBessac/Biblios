<?php

namespace App\Form;

use App\Entity\author;
use App\Entity\Books;
use App\Entity\genre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class BooksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('cover', FileType::class, [
                'mapped' => false,
                'label' => "Image de couverture"
            ])
            ->add('page_number')
            ->add('published_at', null, [
                'widget' => 'single_text',
            ])
            ->add('author', EntityType::class, [
                'class' => author::class,
                'choice_label' => 'name',
                'autocomplete' => true,
            ])
            ->add('genre', EntityType::class, [
                'class' => genre::class,
                'choice_label' => 'name',
                'multiple' => true,
                'autocomplete' => true,
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
