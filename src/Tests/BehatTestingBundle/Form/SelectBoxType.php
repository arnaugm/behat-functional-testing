<?php
/**
 * Arnau González
 * Date: 9/15/14
 * Time: 12:28 PM
 */

namespace Tests\BehatTestingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SelectBoxType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('select_box', 'choice', array(
                'choices' => array(
                    0 => 'option1',
                    1 => 'option2',
                    2 => 'option3',
                ),
                'label' => 'Options',
                'required' => false,
            ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'select_box';
    }
} 