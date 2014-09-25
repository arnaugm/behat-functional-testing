# behat-functional-testing

Play with the different browsers supported by mink and run several behat tests with them.

To execute the tests with the diferent drivers use the defined profiles

* Symfony2 -> bin/behat
* Zombie.js -> bin/behat --profile zombie
* Sahi -> bin/behat --profile sahi
* Selenium2 -> bin/behat --profile selenium2

## Conclusions

### Radio buttons

* It is possible to use the "check" option in radio buttons when using *Sahi*, the other drivers complain expecting a checkbox. For radio buttons it is necessary to create your own step, as there is none defined by default in the MinkExtension.
 * forms.feature

### Visibility

* *Selenium2* is very strict with visibility. It's not possible to click on an element that is not visible to the eyes of the user. In the scenario "Narrow a bug in the select options using selenium2 driver" we discovered that if a hidden select box is analyzed by the *Selenium2* driver, we can get the values of its options but we'll receive empty strings when asking for their texts.

* *Zombie* and *Symfony2* drivers do not support element visibility check and they will crash if we use the method ```isVisible()```.

* *PhantomJS* by default opens a 400x300 window. If the page has elements centered using negative margins, is it possible that some contents falls outside of the visible area which will make *Selenium2* fail trying to detect that content. A possible solution to that is to force the viewport size. This can be done in the ```BeforeScenario``` hook of the context.
 * centered.feature
 * FeatureContext.php