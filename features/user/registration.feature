@registration @FOSUserBundle @javascript

Feature: Register New User
  In order to use the application
  As a brewer
  I first need to be able to register

  Background: This is testing the Friends of Symfony User Bundle and the translation bundle
    This is not a good example of a Behat test

  Scenario:
    Given I am on "/en/login"
    And I follow "Need a Beeriously Account?"
    Then I should be on "/en/register/"
    Then I should see "Register"
    When I fill in the following:
      | Email           | test-user-new-account@beeriously.com |
      | Username        | testusernewaccount                   |
      | Password        | test                                 |
      | Repeat password | test                                 |
      | First name      | Lance                                |
      | Last name       | Painter                              |

    When I press "Register"
    Then I should be on "/en/register/confirmed"
    And I should see "Congrats testusernewaccount, your account is now activated."
    When I follow "Continue to the Beeriously Dashboard >"
    Then I should be on "/en/dashboard"
    Then I should see "Dashboard"
    Then I should see "5 lights"