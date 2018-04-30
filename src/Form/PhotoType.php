<?php
/**
 * Created by PhpStorm.
 * User: thoma
 * Date: 30/04/2018
 * Time: 11:26 AM
 */

namespace App\Form;


use App\Entity\Photo;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('photo_name', TextType::class)
            ->add('upload_date', DateTimeType::class)
            ->add('owner', TextType::class)
            ->add('path', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Photo::class
        ]);
    }
}