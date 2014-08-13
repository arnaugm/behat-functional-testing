<?php

namespace Tests\BehatTestingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Tests\BehatTestingBundle\Form\RadioButtonType;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('TestsBehatTestingBundle:Default:index.html.twig', array('name' => $name));
    }

    public function radioButtonAction()
    {
        $form = $this->createForm(new RadioButtonType());

        return $this->render('TestsBehatTestingBundle:Default:radio-button.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
