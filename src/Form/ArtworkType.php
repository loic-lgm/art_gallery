<?php

namespace App\Form;

use App\Entity\Artwork;
use App\Entity\Category;
use App\Entity\Image;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArtworkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // RECUPERE L'ID DE L'ARTWORK COURANT TODO

        $images = $options['images'];
        $builder
            ->add('name')
            ->add('description')
            ->add('author')
            ->add('createdIn')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name'
            ])
            ->add('mainImage', ChoiceType::class, [
                'label' => 'Choose the main image',
                'mapped' => false,
                'choices' => $images,
                'choice_label' => 'name',
                'choice_value' => 'id',
            ])
            // ->add('mainImage', EntityType::class, [
            //     'label' => 'Choose the main image',
            //     'mapped' => false,
            //     'class' => Image::class,
            //     'query_builder' => function (EntityRepository $er) {
            //         return $er->createQueryBuilder('u')
            //             ->orderBy('u.isMain');
            //     },
            //     'choices' => $images,
            //     'choice_label' => 'name',
            //     'choice_value' => 'id',
            // ])
            ->add('images', FileType::class, [
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Artwork::class,
            'images' => null
        ]);
    }
}
