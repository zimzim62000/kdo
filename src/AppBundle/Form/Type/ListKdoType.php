<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContext;

class ListKdoType extends AbstractType
{

    private $listKdoManager;

    private $security;

    public function  __construct($listKdoManager, SecurityContext $securityContext)
    {
        $this->listKdoManager = $listKdoManager;

        $this->security = $securityContext;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $security = $this->security;

        $builder
            ->add('name', null, array('label' => 'entity.listkdo.name'))
            ->add('slug', null, array('label' => 'entity.listkdo.slug'))
            ->add('password', 'text', array('label' => 'entity.listkdo.password'))
            ->add('user', null, array('label' => 'entity.listkdo.user'));

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($security) {
                $listkdo = $event->getData();
                $form = $event->getForm();

                if ($security->isGranted('ROLE_ADMIN') === false){
                    $form->remove('user');
                    $listkdo->setUser($security->getToken()->getUser());
                }
            }
        );

    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => $this->listKdoManager->getClassName(),
                'attr' => array(
                    'class' => 'customerpanel'
                )
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_listkdo_formtype';
    }
}