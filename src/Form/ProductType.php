<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\SubCategory;
use App\Repository\SubCategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'label' => 'Titre'
            ])
            ->add('description', TextareaType::class, [
                'required' => true,
                'label' => 'Description'

            ])
            ->add('photo', FileType::class, [
                'required' => true,
                'label' => 'Photo'
            ])
            ->add('price', NumberType::class, [
                'required' => true,
                'label' => 'Prix'
            ])
            ->add('features', CollectionType::class, [
                'required' => true,
                'label' => 'Caractéristiques'
            ])
            ->add('subCategory', EntityType::class, [
                'label' => 'Categorie',
                'class' => SubCategory::class,
                'choice_label' => 'name',
                'group_by' => function (SubCategory $sb) {
                    return $sb->getCategory()->getName();
                }
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter un produit',
                'attr' => [
                    'class' => 'btn-form'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
