Feature: test different form particularities
  In order to verify how every driver behaves with different types of forms
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

  # Verify the selected option of a select box, works well with all the emulators
  Scenario: Verify the selected option of a select box
    Given I am on "/select-box-preselected"
    Then the selected option of the field "Options" should be "option2"

  # Narrow a bug in the select options using selenium2 driver -> https://github.com/Behat/MinkSelenium2Driver/issues/178
  Scenario: Narrow a bug in the select options using selenium2 driver
    Given I am on "bug-select-box"
    Then the selected option of the field "Country" should be "Spain"