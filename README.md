# behat-functional-testing

Play with the different browsers supported by mink and run several behat tests with them.

To execute the tests with the diferent drivers use the defined profiles

Symfony2 -> bin/behat
Zombie.js -> bin/behat --profile zombie
Sahi -> bin/behat --profile sahi
Selenium2 -> bin/behat --profile selenium2

## Conclusions
* It is possible to use the "check" option in radio buttons when using sahi, the other drivers complain expecting a checkbox