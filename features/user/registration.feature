@registration @infrastructure @FOSUserBundle @javascript

Feature: Infrastructure Test: Register New User (Friends of Symfony User Bundle Integration Test)

  Scenario:
    Given I am on "/us/login"
    And I follow "Need a Beeriously Account?"
    Then I should be on "/us/register/"
    Then I should see "Register"
    When I fill in the following:
      | Email           | test-user-new-account@beeriously.com |
      | Username        | testusernewaccount                   |
      | Password        | test123456789                        |
      | Repeat password | test123456789                        |
      | First name      | Lance                                |
      | Last name       | Painter                              |
    When I select "us" from "fos_user_registration_form[massVolumePreferenceUnits]"
    When I select "sg" from "fos_user_registration_form[densityPreferenceUnits]"
    When I select "f" from "fos_user_registration_form[temperaturePreferenceUnits]"
    When I press "Register"
    Then I should be on "/us/register/check-email"
    And I should see "An email has been sent to test-user-new-account@beeriously.com. It contains an activation link you must click to activate your account."
    Given I am on "/us/login"
    When I fill in the following:
      | Username        | testusernewaccount                   |
      | Password        | wrongpassword                        |
    When I press "Log in"
    Then I should be on "/us/login"
    And I should see "Account is disabled."
    When I fill in the following:
      | Username        | testusernewaccount                   |
      | Password        | test123456789                        |
    When I press "Log in"
    Then I should be on "/us/login"
    And I should see "Account is disabled."
    When I follow the activation link that was sent in an email for user "testusernewaccount"
    Then I should be on "/us/register/confirmed"
    And I should see "Congrats testusernewaccount, your account is now activated."
    And I follow "Continue to the Beeriously Dashboard"
    Then I should be on "/us/dashboard"
    When I navigate the application menu to "Log out"
    Then I should be on "/us/login"
    When I fill in the following:
      | Username        | testusernewaccount                   |
      | Password        | wrongpassword                        |
    When I press "Log in"
    Then I should be on "/us/login"
    And I should see "Invalid credentials."
    When I fill in the following:
      | Username        | testusernewaccount                   |
      | Password        | test123456789                        |
    When I press "Log in"
    Then I should be on "/us/dashboard"