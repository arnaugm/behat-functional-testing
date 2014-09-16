<?php

namespace Tests\BehatTestingBundle\Features\Context;

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

        $select = $this->getSession()->getPage()->findField($field);
        if (null === $select) {
            throw new ElementNotFoundException($this->getSession(), 'form field', 'id|name|label|value', $select);
        }

        $options = $select->findAll('css', 'option');
        foreach ($options as $option) {
            $optionText = $option->getText();
//            echo $option->getText() . "\n";
//            echo $option->getValue() . "\n";
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
