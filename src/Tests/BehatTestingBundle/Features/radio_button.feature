Feature: test radio buttons particularities
  In order to verify how every driver behaves with radio buttons
  As a developer
  I need to test these differences

  # Only sahi allows to select a radio button in the same way a check box is checked
  Scenario: Change a radio button by checking it
    Given I am on "/radio-button"
    When I check "option1"
    Then the "option1" checkbox should be checked

  # A custom step needs to be defined to be able to select a radio button
  Scenario: Change a radio button by selecting the first option
    Given I am on "/radio-button"
    When I select the "option1" radio button
    Then the "option1" checkbox should be checked

  Scenario: Change a radio button by selecting the second option
    Given I am on "/radio-button"
    When I select the "option2" radio button
    Then the "option2" checkbox should be checked