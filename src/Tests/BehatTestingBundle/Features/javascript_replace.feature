Feature: test problems in selenium2 with text replaced by javascript
  In order to verify where exactly we have problems with text replaced by javascript using selenium2
  As a developer
  I need to test these cases

  Scenario: Check a text that is replaced by javascript
    Given I am on "/javascript_replace"
    Then I should see "Replaced text"