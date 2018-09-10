@brewery @javascript

Feature: Manage Brewers
  In order to have multiple brewers working in the software for a brewery
  As a brewery owner
  I need to be able to manage brewers

  Scenario: Add a Brewer
    Given I am logged in as "Victor Frankenstein" owner of "The Monster's Name Is Not Frankenstein Brewery"
    When I am on the homepage
    And I navigate the application menu to "Brewery Settings"
    Then I should be on "/us/brewery"
    And I press "Add an Assistant Brewer"
    And I wait 5 seconds
    Then I should see "Add an Assistant Brewer"
    Then I should see "A password is not required. A registration link will be sent via email to the brewer."
    And I fill in the following:
        | Username | igorfritzbeeriously  |
        | Email | igor.fritz@beeriously.com |
        | First name | Igor                  |
        | Last name | Fritz                  |
    And I press "Submit"
    Then I should be on "/us/brewery"
    And I should see "Brewer account added successfully"
    And I should see "Igor Fritz"
    And I should see "igor.fritz@beeriously.com"
    And I should see "Brewer \"Igor Fritz\" was added"
    And I should see "By Victor Frankenstein on"
    Then I click the first delete button in the list of brewers
    And I wait 5 seconds
    And I press "Yes, Remove Brewer"
    Then I should be on "/us/brewery"
    And I should see "Brewer account deleted successfully"
    And I should see "Brewer \"Igor Fritz\" was removed"
    And I should see "By Victor Frankenstein on"

