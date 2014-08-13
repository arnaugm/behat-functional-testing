<?php
/**
 * Arnau González
 * Date: 8/13/14
 * Time: 6:26 PM
 */

namespace Tests\BehatTestingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RadioButtonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('radio_button', 'choice', array(
                'choices' => array(
                    0 => 'option1',
                    1 => 'option2',
                ),
                'expanded' => true,
                'multiple' => false,
                'label' => 'Radio button',
                'required' => true,
            ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'radio_button';
    }
}