<?php

namespace App\Form;

use App\Entity\Group;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class UserType
 * @package App\Form
 */
class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('POST')
            ->add(
                'email',
                EmailType::class,
                [
                    //'required' => true,
                    'label'    => false,
                ]
            )
            ->add(
                'last_name',
                null,
                [
                    'property_path' => 'lastName',
                ]
            )
            ->add(
                'first_name',
                null,
                [
                    'property_path' => 'firstName',
                ]
            )
            ->add('state')
            ->add(
                'creation_date',
                DateTimeType::class,
                [
                    'widget'        => 'single_text',
                    'format'        => 'yyyy-MM-dd\'T\'HH:mm:ss',
                    'property_path' => 'creationDate',
                ]
            )
            ->add('groups', EntityType::class, [
                'class'        => Group::class,
                'expanded'     => true,
                'multiple'     => true,
            ])
            ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class'         => User::class,
                'allow_extra_fields' => true,
                'csrf_protection'    => false,
            ]
        );
    }
}


