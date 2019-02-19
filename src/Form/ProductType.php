<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\SubCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'label' => 'Titre'
            ])
            ->add('description', TextareaType::class, [
                'required' => true,
                'label' => 'Description',
                'attr' => [
                    'class' => 'ckeditor'
                ]
            ])
            ->add('photo', FileType::class, [
                'required' => true,
                'label' => 'Photo',
                'attr' => [
                    'class' => 'dropify'
                ]
            ])
            ->add('price', NumberType::class, [
                'required' => true,
                'label' => 'Prix'
            ])
            ->add('subCategory', EntityType::class, [
                'label' => 'Categorie',
                'class' => SubCategory::class,
                'choice_label' => 'name',
                'group_by' => function (SubCategory $sb) {
                    return $sb->getCategory()->getName();
                }
            ])
            ->add('marque', TextType::class, [
                'required' => false,
                'label' => 'Marque'
            ])
            ->add('color', TextType::class, [
                'required' => false,
                'label' => 'Couleur'
            ])
            ->add('composition', TextType::class, [
                'required' => false,
                'label' => 'Composition'
            ])
            ->add('dimension', TextType::class, [
                'required' => false,
                'label' => 'Dimension'
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

    public function getBlockPrefix()
    {
        return 'form';
    }


}
