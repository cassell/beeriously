@registration

Feature: Infrastructure Test: Test User Constraints

  Scenario:
    Given I am on "/"
    Then I should be on "/us/login"
    When I follow "Need a Beeriously Account?"
    Then I should be on "/us/register/"
    When I fill in the following:
      | Email           | test-short-password@beeriously.com |
      | Username        | alc277                             |
      | Password        | alc277                             |
      | Repeat password | alc277                             |
      | First name      | Andrew                             |
      | Last name       | Twitter                            |
    When I press "Register"
    Then I should be on "/us/register/"
    And I should see "Username is not allowed"
    And I should see "Password is too short"
    And I should see "Password can not match username or email"
