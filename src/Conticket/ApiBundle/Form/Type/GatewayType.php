<?php

namespace Conticket\ApiBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

final class GatewayType extends AbstractType
{
    const TYPE_NAME = "gateway";
    const DOCUMENT_CLASS = 'Conticket\ApiBundle\Document\Gateway';
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text')
                ->add('type', 'text')
                ->add('key', 'text');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => static::DOCUMENT_CLASS,
            'csrf_protection' => false
        ]);
    }

    public function getName()
    {
        return static::TYPE_NAME;
    }
}
