Feature: test different form particularities
  In order to verify how every driver behaves with different types of forms
  As a developer
  I need to test these differences

  Scenario: Change a radio button by checking it
    Given I am on "/radio-button"
    When I check "option1"

  Scenario: Change a radio button by selecting the option
    Given I am on "/radio-button"
    When I select the "option1" radio button