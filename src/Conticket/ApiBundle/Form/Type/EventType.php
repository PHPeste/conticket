<?php

namespace Conticket\ApiBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

final class EventType extends AbstractType
{
    const TYPE_NAME = "event";
    const DOCUMENT_CLASS = 'Conticket\ApiBundle\Document\Event';
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text')
                ->add('description', 'text')
                ->add('banner', 'text')
                ->add($builder->create('gateway', new GatewayType()));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => static::DOCUMENT_CLASS,
            'csrf_protection' => false
        ));
    }

    public function getName()
    {
        return static::TYPE_NAME;
    }
}
