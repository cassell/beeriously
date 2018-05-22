@registration @FOSUserBundle @javascript

Feature: Register New User (Friends of Symfony User Bundle Integration Test)
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
    When I select "us" from "fos_user_registration_form[massVolumePreferenceUnits]"
    When I select "sg" from "fos_user_registration_form[densityPreferenceUnits]"
    When I select "f" from "fos_user_registration_form[temperaturePreferenceUnits]"
    When I press "Register"
    Then I should be on "/en/register/confirmed"
    And I should see "Congrats testusernewaccount, your account is now activated."
    When I follow "Continue to the Beeriously Dashboard >"
    Then I should be on "/en/dashboard"
    Then I should see "Dashboard"