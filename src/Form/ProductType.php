<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('product_name')
            ->add('product_description', TextareaType::class)
            ->add('product_summary', TextareaType::class)
            ->add('product_price')
            ->add('product_amount')
            ->add('product_status',ChoiceType::class, [
                'placeholder' => 'Choose an option',
                'choices' => [
                    'Active' => '1',
                    'Deactive' => '0',
                ],
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'multiple' => false,
                'choice_label' => 'category_name',
                'expanded' => false
            ])
            -> add('avatar', FileType::class,
            [
                'data_class' => null,
                'required' => is_null($builder->getData()->getAvatar())
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
