<?php

namespace Tests\BehatTestingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Tests\BehatTestingBundle\Form\RadioButtonType;
use Tests\BehatTestingBundle\Form\SelectBoxType;

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

    public function selectBoxPreselectedAction()
    {
        $form = $this->createForm(new SelectBoxType());
        $form->get('select_box')->setData(1);

        return $this->render('TestsBehatTestingBundle:Default:select-box-preselected.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function bugSelectBoxAction()
    {
        return $this->render('TestsBehatTestingBundle:Default:bug-select-box.html.twig');
    }
}
