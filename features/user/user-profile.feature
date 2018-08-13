@registration @infrastructure @FOSUserBundle @javascript

Feature: Change User Profile Details

  Scenario:
    Given I am logged in as "Jane Alewife" owner of "The Epic Brewery of Gilgamesh"
    When I am on the homepage
    And I navigate the application menu to "Profile"
    Then I should be on "/us/profile/"
    And I should see "Jane Alewife"
    And I should see "The Epic Brewery of Gilgamesh"
    When I follow "Change Username or Email"
    Then I should be on "/us/profile/edit"
    When I fill in the following:
      | Username         | janesiduritest                      |
      | Email            | janesiduritest@gilgamesh.beeriously |
      | Current password | H.R.1337                            |
    When I press "Update"
    Then I should be on "/us/profile/"
    And I should see "The profile has been updated."
    And I should see "janesiduritest"
    And I should see "janesiduritest@gilgamesh.beeriously"
    And I wait 10 seconds