<?php

namespace Tests\BehatTestingBundle\Features\Context;

use Behat\Mink\Driver\SahiDriver;
use Behat\Mink\Driver\Selenium2Driver;
use Behat\Mink\Exception\ElementNotFoundException;
use Behat\Mink\Exception\ExpectationException;
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
     * @BeforeScenario
     */
    public function before($event)
    {
        // To avoid problems due to the size of the viewport when using Selenium2 + PhantomJS
        $driver = $this->getSession()->getDriver();
        if ($driver instanceof Selenium2Driver) {
            $this->getSession()->resizeWindow(1024, 768, 'current');
        }
    }

    /**
     * @Given /^(?:|I )select the "([^"]*)" radio button$/
     */
    public function iSelectTheRadioButton($option)
    {
        $option = $this->fixStepArgument($option);

        $label = $this->getSession()->getPage()->find('xpath', '//label[text()="' . $option . '"]');
        if (null === $label) {
            throw new ElementNotFoundException($this->getSession(), 'form field', 'label', $option);
        }

        $inputId = $label->getAttribute('for');
        if (null === $inputId) {
            throw new ElementNotFoundException($this->getSession(), 'form field', 'label', $option);
        }

        $radio = $this->getSession()->getPage()->find('css', '#' . $inputId);
        if (!$radio->has('css', 'input[type="radio"]')) {
            throw new ElementNotFoundException($this->getSession(), 'form field', 'label', $option);
        }

        $this->fillField($option, $radio->find('css', 'input[type="radio"]')->getAttribute('value'));
    }

    /**
     * @Then /^the selected option of the field "([^"]*)" should be "([^"]*)"$/
     */
    public function theSelectedOptionOfTheFieldShouldBe($field, $text)
    {
        $field = $this->fixStepArgument($field);
        $text = $this->fixStepArgument($text);

        // Find all select boxes with the given label
        $selects = $this->getSession()->getPage()->findAll('xpath', '//label[text()="' . $field . '"]/following::select[1]');
        if (empty($selects)) {
            throw new ElementNotFoundException($this->getSession(), 'select field', 'label', $field);
        }

        // Element visibility check is only supported by Sahi and Selenium2
        $driver = $this->getSession()->getDriver();
        if ($driver instanceof Selenium2Driver || $driver instanceof SahiDriver) {
            // Choose the first visible one among them
            $visibleSelect = null;
            foreach ($selects as $select) {
                if ($select->isVisible()) {
                    $visibleSelect = $select;
                    break;
                }
            }
            if (is_null($visibleSelect)) {
                throw new ElementNotFoundException($this->getSession(), 'visible select field', 'label', $field);
            }
        } else {
            $visibleSelect = $selects[0];
        }

        // Check and compare the selected option
        $options = $visibleSelect->findAll('css', 'option');
        foreach ($options as $option) {
            $optionText = $option->getText();
            if ($option->isSelected()) {
                if ($text == $optionText) {
                    return;
                } else {
                    $message = sprintf('The selected option of "%s" is "%s" and should be "%s".', $field, $optionText, $text);
                    throw new ExpectationException($message, $this->getSession());
                }
            }
        }
        $message = sprintf('The field "%s" does not have any option selected', $field);
        throw new ExpectationException($message, $this->getSession());
    }
}
