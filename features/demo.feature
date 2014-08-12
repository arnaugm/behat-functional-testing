Feature: demo
  In order to test the behat configuration
  As a developer
  I need to be able to check that the default action is testable

  Scenario:
    Given I am on "/hello/Arnau"
    Then I should see "Hello Arnau!"