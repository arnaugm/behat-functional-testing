<?php

namespace Tests\BehatTestingBundle\Features\Context;

use Behat\Mink\Exception\ElementNotFoundException;
use Symfony\Component\HttpKernel\KernelInterface;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Behat\MinkExtension\Context\MinkContext;

use Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Feature context.
 */
class FeatureContext extends MinkContext implements KernelAwareInterface
{
    private $kernel;
    private $parameters;

    /**
     * Initializes context with parameters from behat.yml.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Sets HttpKernel instance.
     * This method will be automatically called by Symfony2Extension ContextInitializer.
     *
     * @param KernelInterface $kernel
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @Given /^(?:|I )select the "([^"]*)" radio button$/
     */
    public function iSelectTheRadioButton($option)
    {
        $label = $this->getSession()->getPage()->find('xpath', '//label[text()="' . $option . '"]');
        $radio = $label->getParent();
        if (null === $label || !$radio->has('css', 'input[type="radio"]')) {
            throw new ElementNotFoundException($this->getSession(), 'form field', 'label', $option);
        }
        $this->fillField($option, $radio->find('css', 'input[type="radio"]')->getAttribute('value'));
    }
}
