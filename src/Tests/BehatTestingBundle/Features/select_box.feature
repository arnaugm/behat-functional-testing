Feature: test select box particularities
  In order to verify how every driver behaves with select boxes
  As a developer
  I need to test these differences

  # Verify the selected option of a select box, works well with all the emulators
  Scenario: Verify the selected option of a select box
    Given I am on "/select-box-preselected"
    Then the selected option of the field "Options" should be "option2"

  # Narrow a bug in the select options using selenium2 driver -> https://github.com/Behat/MinkSelenium2Driver/issues/178
  Scenario: Narrow a bug in the select options using selenium2 driver
    Given I am on "/bug-select-box"
    Then the selected option of the field "Country" should be "Spain"