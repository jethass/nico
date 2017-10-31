<?php

namespace Nicorette\CentralBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class FileType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
				->add('file', 'file', array('label' => null))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => null,
        	'cascade_validation' => true,
        	'csrf_protection'   => false,
        ));
    }

    public function getName() {
        return 'file_type';
    }

}
