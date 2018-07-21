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
    Then I should be on "/us/register/check-email"
    And I should see "An email has been sent to test-user-new-account@beeriously.com. It contains an activation link you must click to activate your account."
