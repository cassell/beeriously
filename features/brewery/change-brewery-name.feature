@brewery @javascript

Feature: Change Brewery Name
  In order to have multiple brewers working in the software for a brewery
  As a brewery owner
  I need to be able to change the name of the brewery

  Scenario:
    Given I am logged in as "Example Brewer" owner of "Change Brewery Name Old Brewery"
    When I am on the homepage
    And I navigate the application menu to "Brewery Settings"
    Then I should be on "/us/brewery"
    And I press "Change Brewery Name"
    And I wait 5 seconds
    And I fill out brewery name form with "New Brewery Name"
    And I click submit change brewery name
    Then I should be on "/us/brewery"
    And I should see "Brewery name updated successfully"
    And I should see "New Brewery Name"
    And I should see "Brewery name was changed to \"New Brewery Name\""

