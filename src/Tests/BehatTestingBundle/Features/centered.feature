Feature: test problems in selenium2 + phantomjs with negative margins
  In order to verify where exactly we have problems with negative margins in selenium2 + phantomjs
  As a developer
  I need to test these cases

  # The test fails when using selenium2 + phantomjs if we don't change the viewport size in the context
  Scenario: centered
    Given I am on "centered"
    Then I should see "Title"