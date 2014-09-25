# behat-functional-testing

Play with the different browsers supported by ***mink*** and run several ***behat*** tests with them.

To execute the tests with the diferent drivers use the defined profiles:

* Symfony2 -> bin/behat
* Zombie.js -> bin/behat --profile zombie
* Sahi + Chrome -> bin/behat --profile sahi
* Sahi + PhantomJS -> bin/behat --profile sahi_phantomjs
* Selenium2 + Chrome -> bin/behat --profile selenium2
* Selenium2 + PhantomJS -> bin/behat --profile selenium2_phantomjs

## Used versions
* PHP **5.5.9-1ubuntu4.4**
* Selenium2 **2.42.2**
* Sahi (open source) **4.4**
* PhantomJS **1.9.7**
* NodeJS **v0.10.28**
* ZombieJS **2.0.0-alpha31**

---
* behat/behat                          **v2.5.0**             Scenario-oriented BDD framework for PHP 5.3
* behat/gherkin                        **v2.2.9**             Gherkin DSL parser for PHP 5.3
* behat/mink                           **dev-master b887dad** Web acceptance testing framework for PHP 5.3
* behat/mink-browserkit-driver         **dev-master a305d46** Symfony2 BrowserKit driver for Mink framework
* behat/mink-extension                 **v1.3.3**             Mink extension for Behat
* behat/mink-goutte-driver             **dev-master e4d2db0** Goutte driver for Mink framework
* behat/mink-sahi-driver               **dev-master d2aa97b** Sahi.JS driver for Mink framework
* behat/mink-selenium2-driver          **dev-master fef36e8** Selenium2 (WebDriver) driver for Mink framework
* behat/mink-zombie-driver             **dev-master 5951cfa** Zombie.js driver for Mink framework
* behat/sahi-client                    **dev-master 56a2224** Sahi.js client for PHP 5.3
* behat/symfony2-extension             **v1.1.2**             Symfony2 framework extension for Behat
* fabpot/goutte                        **v1.0.6**             A simple PHP Web Scraper
* instaclick/php-webdriver             **dev-master a57b2bc** PHP WebDriver for Selenium 2
* symfony/symfony                      **v2.3.17**            The Symfony PHP framework


## Conclusions

### Radio buttons

* It is possible to use the "check" option in radio buttons when using **Sahi**, the other drivers complain expecting a checkbox. For radio buttons it is necessary to create your own step, as there is none defined by default in the MinkExtension.
 * radio_button.feature

### Visibility

* **Selenium2** is very strict with visibility. It's not possible to click on an element that is not visible to the eyes of the user. In the scenario "Narrow a bug in the select options using selenium2 driver" we discovered that if a hidden select box is analyzed by the **Selenium2** driver, we can get the values of its options but we'll receive empty strings when asking for their texts.
 * select_box.feature

* **Zombie** and **Symfony2** drivers do not support element visibility check and they will crash if we use the method ```isVisible()```.
 * select_box.feature
 * FeatureContext.php -> ```theSelectedOptionOfTheFieldShouldBe()```

* **PhantomJS** by default opens a 400x300 window. If the page has elements centered using negative margins, it is possible that some contents falls outside of the visible area which will make **Selenium2** fail trying to detect that content. A possible solution to that is to force the viewport size. This can be done in the ```BeforeScenario``` hook of the context.
 * centered.feature
 * FeatureContext.php -> ```before()```