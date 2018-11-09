@registration @infrastructure @FOSUserBundle @javascript

Feature: Infrastructure Test: Change User Profile Details

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
    When I follow "Change Password"
    Then I should be on "/us/profile/change-password"
    When I fill in the following:
      | Current password    | H.R.1337 |
      | New password        | Uruk     |
      | Repeat new password | Uruk     |
    And I press "Change password"
    Then I should be on "/us/profile/change-password"
    And I should see "Password is too short"
    When I fill in the following:
      | Current password    | H.R.1337 |
      | New password        | Uruk-hai |
      | Repeat new password | Uruk-hai |
    When I press "Change password"
    Then I should be on "/us/profile/"
    And I should see "The password has been changed."
    When I follow "Change Name"
    Then I should be on "/us/brewer/name/change"
    And I should see "Change Name"
    When I fill in the following:
      | First name | Jane   |
      | Last name  | Siduri |
    And I press "Submit"
    Then I should be on "/us/profile/"
    And I should see "Brewer Name Changed Successfully"
